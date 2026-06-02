<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CompareCallsController extends Controller
{
    public function index()
    {
        $connection1 = 'prod_2';
        $connection2 = 'vprod_2';
        $table = 'calls';
        $keyField = 'link_id';
        $hasSoftDeletes = false;
        $title = 'Calls Comparison';
        $columns = [
            'id' => 'ID',
            'call_time' => 'Call Time',
            'link_id' => 'Link ID',
            
        ];
        $filterConfig = $this->filterConfig($table);
        $request = request();

        $baseQuery1 = $this->applyFilters(DB::connection($connection1)->table($table), $filterConfig, $request, 'c1');
        $baseQuery2 = $this->applyFilters(DB::connection($connection2)->table($table), $filterConfig, $request, 'c2');

        // ── Lightweight queries for comparison logic ──
        $c1AllKeyValues = (clone $baseQuery1)->pluck($keyField)->toArray();
        $c1Active = null;
        $c1Inactive = null;
        $c1ActiveCount = null;

        // ── Full collections for merged computation ──
        $c1AllFull = (clone $baseQuery1)->orderBy('id')->get();

        // ── Paginated display queries ──
        $c1All = (clone $baseQuery1)->orderBy('id')->paginate(100, pageName: 'c1_page');
        $c2All = (clone $baseQuery2)->orderBy('id')->paginate(100, pageName: 'c2_page');

        // ── v2 collections ──
        $c2Active = null;
        $c2Inactive = null;
        $c2ActiveCount = null;

        // ── Step 3 & 4: Unique + Merged ──
        $c2UniqueActiveQuery = (clone $baseQuery2)
            ->whereNotIn($keyField, $c1AllKeyValues)
            ->orderBy('id');
        $c2UniqueActiveFull = $c2UniqueActiveQuery->get();
        $c2UniqueActive = $c2UniqueActiveQuery->paginate(100, pageName: 'c3_page');

        $mergedFull = $c1AllFull->concat($c2UniqueActiveFull)->sortBy($keyField)->values();
        $mergedCount = $mergedFull->count();
        $currentMergedPage = LengthAwarePaginator::resolveCurrentPage('c4_page');
        $merged = new LengthAwarePaginator(
            $mergedFull->forPage($currentMergedPage, 100)->values(),
            $mergedCount,
            100,
            $currentMergedPage,
            ['pageName' => 'c4_page', 'path' => request()->url(), 'query' => request()->query()]
        );

        $c1FilterValues = $this->getFilterValues($connection1, $filterConfig);
        $c2FilterValues = $this->getFilterValues($connection2, $filterConfig);
        $c1ActiveFilters = $this->getActiveFilters($request, $filterConfig, 'c1');
        $c2ActiveFilters = $this->getActiveFilters($request, $filterConfig, 'c2');

        return view('compare-layout', compact(
            'title', 'table', 'keyField', 'hasSoftDeletes', 'columns',
            'c1All', 'c1Active', 'c1Inactive', 'c1ActiveCount',
            'c2All', 'c2Active', 'c2Inactive', 'c2ActiveCount',
            'c2UniqueActive', 'merged', 'mergedCount', 'c1AllKeyValues',
            'filterConfig', 'c1FilterValues', 'c2FilterValues', 'c1ActiveFilters', 'c2ActiveFilters'
        ));
    }
}