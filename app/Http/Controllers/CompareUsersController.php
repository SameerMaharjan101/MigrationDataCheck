<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CompareUsersController extends Controller
{
    public function index()
    {
        $filterConfig = $this->filterConfig('user');
        $request = request();

        $baseQuery1 = $this->applyFilters(DB::connection('prod_2')->table('user'), $filterConfig, $request, 'c1');
        $baseQuery2 = $this->applyFilters(DB::connection('vprod_2')->table('user'), $filterConfig, $request, 'c2');

        // ── Lightweight queries ──
        $prod2AllUsernames = (clone $baseQuery1)
            ->pluck('username')
            ->toArray();

        // Active users (deleted_at IS NULL)
        $prod2ActiveUsers = (clone $baseQuery1)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();

        // Inactive users (deleted_at IS NOT NULL)
        $prod2InactiveUsers = (clone $baseQuery1)
            ->whereNotNull('deleted_at')
            ->orderBy('id')
            ->get();

        $prod2ActiveCount = $prod2ActiveUsers->count();

        // ── Paginated display queries ──
        $prod2AllUsers = (clone $baseQuery1)
            ->orderBy('id')
            ->paginate(100, pageName: 'c1_page');

        $vprod2AllUsers = (clone $baseQuery2)
            ->orderBy('id')
            ->paginate(100, pageName: 'c2_page');

        // ── Full v2 collections for counts ──
        $vprod2ActiveUsers = (clone $baseQuery2)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();

        $vprod2InactiveUsers = (clone $baseQuery2)
            ->whereNotNull('deleted_at')
            ->orderBy('id')
            ->get();

        $vprod2ActiveCount = $vprod2ActiveUsers->count();

        // ── Step 3 & 4 ──
        $vprod2UniqueActiveUsersQuery = (clone $baseQuery2)
            ->whereNull('deleted_at')
            ->whereNotIn('username', $prod2AllUsernames)
            ->orderBy('id');

        $vprod2UniqueActiveUsersFull = $vprod2UniqueActiveUsersQuery->get();
        $vprod2UniqueActiveUsers = $vprod2UniqueActiveUsersQuery->paginate(100, pageName: 'c3_page');

        $mergedActiveUsersFull = $prod2ActiveUsers->concat($vprod2UniqueActiveUsersFull)
            ->sortBy('username')
            ->values();

        $mergedActiveCount = $mergedActiveUsersFull->count();
        $currentMergedPage = LengthAwarePaginator::resolveCurrentPage('c4_page');
        $mergedActiveUsers = new LengthAwarePaginator(
            $mergedActiveUsersFull->forPage($currentMergedPage, 100)->values(),
            $mergedActiveCount,
            100,
            $currentMergedPage,
            ['pageName' => 'c4_page', 'path' => request()->url(), 'query' => request()->query()]
        );

        $c1FilterValues = $this->getFilterValues('prod_2', $filterConfig);
        $c2FilterValues = $this->getFilterValues('vprod_2', $filterConfig);
        $c1ActiveFilters = $this->getActiveFilters($request, $filterConfig, 'c1');
        $c2ActiveFilters = $this->getActiveFilters($request, $filterConfig, 'c2');

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
            'mergedActiveCount',
            'filterConfig', 'c1FilterValues', 'c2FilterValues', 'c1ActiveFilters', 'c2ActiveFilters'
        ));
    }
}
