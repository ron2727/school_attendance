<?php

use App\Http\Controllers\ClassesController; 
use App\Http\Controllers\TeacherController;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Auth/Login');
});


Route::inertia('dashboard', 'Admin/Dashboard')->name('dashboard');
 

Route::resource('teacher', TeacherController::class);
Route::resource('classes', ClassesController::class);

Route::get('test', function(Request $request){
    $academic_year = $request->input('academic_year');

    return  Classes::where('academic_year', 2023)
                    ->with(['user' => function ($query)  {
                        $query->where('role', 'teacher');
                     }])  
                     ->whereHas('user', function ($query)  {
                        $query->where('role', 'teacher');
                     }) 
                    ->orderByDesc('id')
                    ->paginate(12)
                    ->withQueryString();
});