<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'agent'])) {
            return redirect()->route('admin.dashboard');
        }

        // You might want to pass counts or recent activity to the dashboard
        $offersCount = $user->offers()->count();
        $favoritesCount = $user->favorites()->count();
        $unreadMessagesCount = \App\Models\PropertyMessage::where('receiver_id', $user->id)->where('is_read', false)->count();

        return view('user.dashboard', compact('user', 'offersCount', 'favoritesCount', 'unreadMessagesCount'));
    }

    /**
     * Show the investment credits page.
     */
    public function credits()
    {
        $user = Auth::user();
        $completedCount = \App\Models\UserCompletedProperty::where('user_id', $user->id)->count();

        return view('user.credits.index', compact('user', 'completedCount'));
    }
}
