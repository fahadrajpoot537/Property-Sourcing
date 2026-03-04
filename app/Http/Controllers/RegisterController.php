<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'budget' => ['nullable', 'numeric'],
            'property_interests' => ['nullable', 'array'],
            'role' => ['required', 'in:user,agent'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'phone_number' => $request->phone, // Fill both for compatibility
            'address' => $request->location,
            'address_line1' => $request->location, // Fill both for compatibility
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'budget' => $request->budget,
            'property_interests' => $request->property_interests ? implode(', ', $request->property_interests) : null,
            'status' => 1,
            'is_active' => true,
        ]);

        Auth::login($user);

        // Send Welcome Email
        try {
            \Illuminate\Support\Facades\Mail::mailer('no_reply')->to($user->email)->send(new \App\Mail\UserWelcomeMail($user));
        } catch (\Exception $e) {
            \Log::error("Failed to send web registration welcome email: " . $e->getMessage());
        }

        return redirect()->route('home')->with('success', 'Registration successful! Welcome to Property Sourcing Group.');
    }
}
