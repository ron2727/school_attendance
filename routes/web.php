<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
 
Route::middleware('guest')->group(function(){ 
    Route::inertia('/','Auth/Login')->name('login');
    Route::post('auth', [LoginController::class, 'authenticate'])->name('login.auth'); 
});
 
Route::middleware('auth')->group(function(){

    Route::delete('auth', [LoginController::class, 'destroy'])->name('login.destroy'); 

    Route::middleware('teacher')->group(function(){  
        Route::get('teacher/classes', [ClassesController::class, 'teacherClasses'])->name('teacher.classes.index');
        Route::get('teacher/attendance', [TeacherController::class, 'teacherClasses'])->name('teacher.attendance.index');
    });

    Route::middleware('admin')->group(function(){ 
        Route::get('dashboard', function(){
            return inertia('Admin/Dashboard');
        })->name('dashboard');
        Route::resource('teacher', TeacherController::class);
        Route::resource('classes', ClassesController::class);
        Route::resource('student', StudentController::class); 
    }); 

});


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