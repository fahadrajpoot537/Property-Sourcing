<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($request->title);

        // Handle duplicate slug
        $count = News::where('slug', 'like', $validated['slug'] . '%')->count();
        if ($count > 0) {
            $validated['slug'] .= '-' . ($count + 1);
        }

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('news', 'public');
        }

        News::create($validated);

        return redirect()->route('admin.news.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if ($request->title !== $news->title) {
            $validated['slug'] = Str::slug($request->title);
            $count = News::where('slug', 'like', $validated['slug'] . '%')->where('id', '!=', $news->id)->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . ($count + 1);
            }
        }

        if ($request->hasFile('image')) {
            if ($news->image_url) {
                Storage::disk('public')->delete($news->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('news', 'public');
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(News $news)
    {
        if ($news->image_url) {
            Storage::disk('public')->delete($news->image_url);
        }
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Blog post deleted successfully.');
    }
}
