<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CompareContactController extends Controller
{
    public function index()
    {
        $connection1 = 'prod_2';
        $connection2 = 'vprod_2';
        $table = 'contact';
        $keyField = 'email';
        $hasSoftDeletes = false;
        $title = 'Contact Comparison';
        $columns = [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'extension' => 'Extension',
            'phone_number' => 'Phone',
            'email' => 'Email',
        ];

        $c1All = DB::connection($connection1)->table($table)->orderBy('id')->get();
        $c1Active = null;
        $c1Inactive = null;
        $c1ActiveCount = null;

        $c2All = DB::connection($connection2)->table($table)->orderBy('id')->get();
        $c2Active = null;
        $c2Inactive = null;
        $c2ActiveCount = null;

        $c1AllKeyValues = $c1All->pluck($keyField)->toArray();
        $c2UniqueActive = DB::connection($connection2)
            ->table($table)
            ->whereNotIn($keyField, $c1AllKeyValues)
            ->orderBy('id')
            ->get();

        $merged = $c1All->concat($c2UniqueActive)->sortBy($keyField)->values();
        $mergedCount = $merged->count();

        return view('compare-layout', compact(
            'title', 'table', 'keyField', 'hasSoftDeletes', 'columns',
            'c1All', 'c1Active', 'c1Inactive', 'c1ActiveCount',
            'c2All', 'c2Active', 'c2Inactive', 'c2ActiveCount',
            'c2UniqueActive', 'merged', 'mergedCount'
        ));
    }
}
