<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CompareUsersController extends Controller
{
    public function index()
    {
        // ──────────────────────────────────────────────
        // Step 1: Access user table from prod_2
        // ──────────────────────────────────────────────

        // All users
        $prod2AllUsers = DB::connection('prod_2')
            ->table('user')
            ->orderBy('id')
            ->get();

        // Active users (deleted_at IS NULL)
        $prod2ActiveUsers = DB::connection('prod_2')
            ->table('user')
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();

        // Inactive users (deleted_at IS NOT NULL)
        $prod2InactiveUsers = DB::connection('prod_2')
            ->table('user')
            ->whereNotNull('deleted_at')
            ->orderBy('id')
            ->get();

        // Count active users
        $prod2ActiveCount = $prod2ActiveUsers->count();

        // ──────────────────────────────────────────────
        // Step 2: Access user table from vprod_2
        // ──────────────────────────────────────────────

        // All users
        $vprod2AllUsers = DB::connection('vprod_2')
            ->table('user')
            ->orderBy('id')
            ->get();

        // Active users (deleted_at IS NULL)
        $vprod2ActiveUsers = DB::connection('vprod_2')
            ->table('user')
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();

        // Inactive users (deleted_at IS NOT NULL)
        $vprod2InactiveUsers = DB::connection('vprod_2')
            ->table('user')
            ->whereNotNull('deleted_at')
            ->orderBy('id')
            ->get();

        // Count active users
        $vprod2ActiveCount = $vprod2ActiveUsers->count();

        // ──────────────────────────────────────────────
        // Step 3: Active users from vprod_2 not in prod_2 (unique by username)
        // Exclude vprod_2 active user if that username already exists in prod_2
        // (whether active or deleted)
        // ──────────────────────────────────────────────

        $prod2AllUsernames = $prod2AllUsers->pluck('username')->toArray();

        $vprod2UniqueActiveUsers = DB::connection('vprod_2')
            ->table('user')
            ->whereNull('deleted_at')
            ->whereNotIn('username', $prod2AllUsernames)
            ->orderBy('id')
            ->get();

        // ──────────────────────────────────────────────
        // Step 4: Merge list of active users from prod_2 and vprod_2
        // ──────────────────────────────────────────────

        $mergedActiveUsers = $prod2ActiveUsers->concat($vprod2UniqueActiveUsers)
            ->sortBy('username')
            ->values();

        $mergedActiveCount = $mergedActiveUsers->count();

        // ──────────────────────────────────────────────
        // Pass all to view
        // ──────────────────────────────────────────────

        return view('compare-users', compact(
            'prod2AllUsers',
            'prod2ActiveUsers',
            'prod2InactiveUsers',
            'prod2ActiveCount',
            'vprod2AllUsers',
            'vprod2ActiveUsers',
            'vprod2InactiveUsers',
            'vprod2ActiveCount',
            'vprod2UniqueActiveUsers',
            'mergedActiveUsers',
            'mergedActiveCount'
        ));
    }
}
