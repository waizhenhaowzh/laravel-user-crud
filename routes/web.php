<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Frontend (Blade) routes only
*/

Route::get('/', function () {
    return redirect('/users');
});

// User Management Frontend Page
Route::get('/users', function () {
    return view('users.index');
});