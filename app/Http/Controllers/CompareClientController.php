<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CompareClientController extends Controller
{
    public function index()
    {
        $connection1 = 'prod_2';
        $connection2 = 'vprod_2';
        $table = 'client';
        $keyField = 'id';
        $hasSoftDeletes = true;
        $title = 'Client Comparison';
        $columns = [
            'id' => 'ID',
            'remarks' => 'Remarks',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
            'deleted_at' => 'Deleted At',
            
        ];
        $filterConfig = $this->filterConfig($table);
        $request = request();

        $baseQuery1 = $this->applyFilters(DB::connection($connection1)->table($table), $filterConfig, $request, 'c1');
        $baseQuery2 = $this->applyFilters(DB::connection($connection2)->table($table), $filterConfig, $request, 'c2');

        // ── Lightweight queries ──
        $c1AllKeyValues = (clone $baseQuery1)->pluck($keyField)->toArray();
        $c1Active = (clone $baseQuery1)->whereNull('deleted_at')->orderBy('id')->get();
        $c1Inactive = (clone $baseQuery1)->whereNotNull('deleted_at')->orderBy('id')->get();
        $c1ActiveCount = $c1Active->count();

        // ── Paginated display queries ──
        $c1All = (clone $baseQuery1)->orderBy('id')->paginate(100, pageName: 'c1_page');
        $c2All = (clone $baseQuery2)->orderBy('id')->paginate(100, pageName: 'c2_page');

        // ── Full v2 collections for counts ──
        $c2Active = (clone $baseQuery2)->whereNull('deleted_at')->orderBy('id')->get();
        $c2Inactive = (clone $baseQuery2)->whereNotNull('deleted_at')->orderBy('id')->get();
        $c2ActiveCount = $c2Active->count();

        $c2UniqueActive = null;
        $merged = null;
        $mergedCount = null;

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
