<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Controller;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Temporarily use the no-reply mailer configuration
        $originalMailer = config('mail.default');
        $originalFrom = config('mail.from.address');
        
        config(['mail.default' => 'no_reply']);
        
        // Ensure log driver is used if specified in .env to prevent local SMTP hang
        if (env('MAIL_MAILER') === 'log') {
            config(['mail.mailers.no_reply.transport' => 'log']);
        }

        // Set from address to the no-reply account
        config(['mail.from.address' => env('MAIL_NOREPLY_USERNAME', $originalFrom)]);

        $status = Password::sendResetLink($request->only('email'));
        
        // Restore original mailer and from address
        config(['mail.default' => $originalMailer]);
        config(['mail.from.address' => $originalFrom]);

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
