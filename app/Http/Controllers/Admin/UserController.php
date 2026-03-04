<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        // Load relationships like properties or offers if applicable
        $user->load(['properties', 'offers.property']);
        return view('admin.users.show', compact('user'));
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $user->update([
            'status' => $request->status,
        ]);

        $statusText = $request->status == 1 ? 'approved' : 'set to pending';
        return back()->with('success', "User account has been {$statusText} successfully.");
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,agent',
        ]);

        if ($user->role === 'admin') {
            return back()->with('error', 'Admin role cannot be changed.');
        }

        $user->update([
            'role' => $request->role,
        ]);

        return back()->with('success', "User role has been updated to {$request->role}.");
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin accounts cannot be deleted.');
        }

        $user->delete();
        return back()->with('success', 'User account deleted successfully.');
    }
}
