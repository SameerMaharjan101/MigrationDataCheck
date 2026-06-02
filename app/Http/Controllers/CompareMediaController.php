<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CompareMediaController extends Controller
{
    public function index()
    {
        $connection1 = 'prod_2';
        $connection2 = 'vprod_2';
        $table = 'media';
        $keyField = 'file_name';
        $hasSoftDeletes = false;
        $title = 'Media Comparison';
        $columns = [
            'id' => 'ID',
            'entity_type' => 'Entity Type',
            'file_name' => 'File Name',
            'mime_type' => 'MIME Type',
            'size' => 'Size',
            'created_at' => 'Created',
            
        ];
        // ── Lightweight queries for comparison logic ──
        $c1AllKeyValues = DB::connection($connection1)->table($table)->pluck($keyField)->toArray();
        $c1Active = null;
        $c1Inactive = null;
        $c1ActiveCount = null;

        // ── Full collections for merged computation ──
        $c1AllFull = DB::connection($connection1)->table($table)->orderBy('id')->get();

        // ── Paginated display queries ──
        $c1All = DB::connection($connection1)->table($table)->orderBy('id')->paginate(100, pageName: 'c1_page');
        $c2All = DB::connection($connection2)->table($table)->orderBy('id')->paginate(100, pageName: 'c2_page');

        // ── v2 collections ──
        $c2Active = null;
        $c2Inactive = null;
        $c2ActiveCount = null;

        // ── Step 3 & 4: Unique + Merged ──
        $c2UniqueActiveQuery = DB::connection($connection2)
            ->table($table)
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
        return view('compare-layout', compact(
            'title', 'table', 'keyField', 'hasSoftDeletes', 'columns',
            'c1All', 'c1Active', 'c1Inactive', 'c1ActiveCount',
            'c2All', 'c2Active', 'c2Inactive', 'c2ActiveCount',
            'c2UniqueActive', 'merged', 'mergedCount', 'c1AllKeyValues'
        ));
    }
}