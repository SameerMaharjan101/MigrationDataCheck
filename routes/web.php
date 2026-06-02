<?php

use App\Http\Controllers\CompareUsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/compare-users', [CompareUsersController::class, 'index']);
