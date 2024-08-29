<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Auth/Login');
});


Route::inertia('dashboard', 'Admin/Dashboard')->name('dashboard');

Route::inertia('classes', 'Admin/Classes/Index')->name('classes.index');