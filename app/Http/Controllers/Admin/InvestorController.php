<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Investor::with('agent')->latest();

        // Agents can only see their own investors, Admins see all
        if (Auth::user()->role !== 'admin') {
            $query->where('agent_id', Auth::id());
        }

        $investors = $query->paginate(15);
        return view('admin.investors.index', compact('investors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.investors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'property_interests' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $interests = $request->property_interests ? implode(', ', $request->property_interests) : null;

        Investor::create([
            'agent_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'property_interests' => $interests,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.investors.index')->with('success', 'Investor added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $investor = Investor::findOrFail($id);

        // Authorization
        if (Auth::user()->role !== 'admin' && $investor->agent_id !== Auth::id()) {
            abort(403);
        }

        return view('admin.investors.show', compact('investor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $investor = Investor::findOrFail($id);

        // Authorization
        if (Auth::user()->role !== 'admin' && $investor->agent_id !== Auth::id()) {
            abort(403);
        }

        $selectedInterests = $investor->property_interests ? explode(', ', $investor->property_interests) : [];

        return view('admin.investors.edit', compact('investor', 'selectedInterests'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $investor = Investor::findOrFail($id);

        // Authorization
        if (Auth::user()->role !== 'admin' && $investor->agent_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'property_interests' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $interests = $request->property_interests ? implode(', ', $request->property_interests) : null;

        $investor->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'property_interests' => $interests,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.investors.index')->with('success', 'Investor updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $investor = Investor::findOrFail($id);

        // Authorization
        if (Auth::user()->role !== 'admin' && $investor->agent_id !== Auth::id()) {
            abort(403);
        }

        $investor->delete();

        return redirect()->route('admin.investors.index')->with('success', 'Investor removed successfully!');
    }
}
