<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update the profile in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'postcode' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_registration' => ['nullable', 'string', 'max:100'],
            'about_me' => ['nullable', 'string', 'max:1000'],
            'budget' => ['nullable', 'numeric'],
            'property_interests' => ['nullable', 'array'],
        ]);

        $data = $request->only([
            'name',
            'email',
            'phone_number',
            'address_line1',
            'address_line2',
            'city',
            'postcode',
            'country',
            'company_name',
            'company_registration',
            'about_me',
            'budget',
        ]);

        if ($request->has('property_interests')) {
            $data['property_interests'] = implode(', ', $request->property_interests);
        }

        // Keep legacy/alternate fields in sync
        $data['phone'] = $request->phone_number;
        $data['address'] = $request->address_line1;

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }
}
