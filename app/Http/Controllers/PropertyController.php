<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function dashboard()
    {
        $properties = Property::latest();

        // Basic stats for dashboard
        $stats = [
            'total_properties' => Property::count(),
            'avg_bmv' => Property::avg('bmv_percentage') ?? 0,
            'recent_properties' => Property::latest()->take(5)->get()
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function index()
    {
        $properties = Property::latest()->paginate(10);
        return view('admin.portfolio', compact('properties'));
    }


    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'bmv_percentage' => 'required|string|max:50',
            'image' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('properties', 'public');
        }

        $validated['user_id'] = Auth::id();

        Property::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Property created successfully.');
    }

    public function edit(Property $property)
    {
        return view('admin.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'bmv_percentage' => 'required|string|max:50',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('properties', 'public');
        }

        $property->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Property deleted successfully.');
    }
}
