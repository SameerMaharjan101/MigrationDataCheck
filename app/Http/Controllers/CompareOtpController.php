<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CompareOtpController extends Controller
{
    public function index()
    {
        $connection1 = 'prod_2';
        $connection2 = 'vprod_2';
        $table = 'otp';
        $keyField = 'otp';
        $hasSoftDeletes = true;
        $title = 'OTP Comparison';
        $columns = [
            'id' => 'ID',
            'otp' => 'OTP',
            'expire_at' => 'Expires At',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
            'deleted_at' => 'Deleted At',
        ];

        $c1All = DB::connection($connection1)->table($table)->orderBy('id')->get();
        $c1Active = DB::connection($connection1)->table($table)->whereNull('deleted_at')->orderBy('id')->get();
        $c1Inactive = DB::connection($connection1)->table($table)->whereNotNull('deleted_at')->orderBy('id')->get();
        $c1ActiveCount = $c1Active->count();

        $c2All = DB::connection($connection2)->table($table)->orderBy('id')->get();
        $c2Active = DB::connection($connection2)->table($table)->whereNull('deleted_at')->orderBy('id')->get();
        $c2Inactive = DB::connection($connection2)->table($table)->whereNotNull('deleted_at')->orderBy('id')->get();
        $c2ActiveCount = $c2Active->count();

        $c1AllKeyValues = $c1All->pluck($keyField)->toArray();
        $c2UniqueActive = DB::connection($connection2)
            ->table($table)
            ->whereNull('deleted_at')
            ->whereNotIn($keyField, $c1AllKeyValues)
            ->orderBy('id')
            ->get();

        $merged = $c1Active->concat($c2UniqueActive)->sortBy($keyField)->values();
        $mergedCount = $merged->count();

        return view('compare-layout', compact(
            'title', 'table', 'keyField', 'hasSoftDeletes', 'columns',
            'c1All', 'c1Active', 'c1Inactive', 'c1ActiveCount',
            'c2All', 'c2Active', 'c2Inactive', 'c2ActiveCount',
            'c2UniqueActive', 'merged', 'mergedCount'
        ));
    }
}
