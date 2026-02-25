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
    public function store(Request $request, \App\Services\PropertyMatchingService $matchingService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'budget' => 'nullable|string|max:255',
            'investment_interest' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'property_interests' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $interests = $request->property_interests ? implode(', ', $request->property_interests) : null;

        // Auto-generate User account if email provided
        $userId = null;
        if ($request->email) {
            $password = \Illuminate\Support\Str::random(10);
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'password' => \Illuminate\Support\Facades\Hash::make($password),
                'role' => 'user', // Investor role
            ]);
            $userId = $user->id;

            // Send Welcome Email
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\InvestorWelcomeMail($user, $password));
        }

        $investor = Investor::create([
            'agent_id' => Auth::id(),
            'user_id' => $userId,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'budget' => $request->budget,
            'investment_interest' => $request->investment_interest,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'property_interests' => $interests,
            'notes' => $request->notes,
        ]);

        // Auto-match check
        $matchingService->findMatchesForInvestor($investor);

        return redirect()->route('admin.investors.index')->with('success', 'Investor added successfully! A welcome email has been sent ' . ($userId ? 'with login credentials.' : ' (Note: No email provided, user account not created).'));
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
    public function update(Request $request, string $id, \App\Services\PropertyMatchingService $matchingService)
    {
        $investor = Investor::findOrFail($id);

        // Authorization
        if (Auth::user()->role !== 'admin' && $investor->agent_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . ($investor->user_id ?? 'NULL') . ',id',
            'phone' => 'nullable|string|max:20',
            'budget' => 'nullable|string|max:255',
            'investment_interest' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'property_interests' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $interests = $request->property_interests ? implode(', ', $request->property_interests) : null;

        $investor->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'budget' => $request->budget,
            'investment_interest' => $request->investment_interest,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'property_interests' => $interests,
            'notes' => $request->notes,
        ]);

        // If email changed, we should ideally update the linked User account
        if ($investor->user_id) {
            $user = \App\Models\User::find($investor->user_id);
            if ($user) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_number' => $request->phone,
                ]);
            }
        }

        // Re-check matches
        $matchingService->findMatchesForInvestor($investor);

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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));
        $header = array_shift($rows);

        $count = 0;
        foreach ($rows as $row) {
            if (count($row) < count($header))
                continue;

            $data = array_combine($header, $row);

            if (empty($data['name']))
                continue;

            Investor::create([
                'agent_id' => Auth::id(),
                'name' => $data['name'] ?? null,
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'budget' => $data['budget'] ?? null,
                'investment_interest' => $data['investment_interest'] ?? null,
                'notes' => $data['notes'] ?? 'Imported from CSV',
            ]);
            $count++;
        }

        return redirect()->route('admin.investors.index')->with('success', "$count Investors imported successfully!");
    }
}
