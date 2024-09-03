<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentClassesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherReportController;
use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Student;
use App\Models\StudentClasses;
use App\Models\User;
use App\Repositories\StudentClassesRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPdf\Facades\Pdf;

Route::middleware('guest')->group(function(){ 
    Route::inertia('/','Auth/Login')->name('login');
    Route::post('auth', [LoginController::class, 'authenticate'])->name('login.auth'); 
});
 
Route::middleware('auth')->group(function(){

    Route::delete('auth', [LoginController::class, 'destroy'])->name('login.destroy'); 

    Route::middleware('teacher')->group(function(){  
        Route::get('teacher/classes', [ClassesController::class, 'classes'])->name('teacher.classes.index');
        Route::get('teacher/classes/{class}/students', [ClassesController::class, 'classStudents'])->name('teacher.classes.students');
        Route::post('teacher/classes/students', [StudentClassesController::class, 'store'])->name('teacher.classes.students.store');

        Route::get('teacher/attendance', [AttendanceController::class, 'index'])->name('teacher.attendance.index');
        Route::get('teacher/attendance/{class}/students', [AttendanceController::class, 'classStudents'])->name('teacher.attendance.students');
        Route::post('teacher/attendance/students', [AttendanceController::class, 'store'])->name('teacher.attendance.students.store');
        Route::put('teacher/attendance/students', [AttendanceController::class, 'update'])->name('teacher.attendance.students.update');

        Route::get('teacher/report', [TeacherReportController::class, 'index'])->name('teacher.report.index');
        Route::get('teacher/report/{class}/generate', [TeacherReportController::class, 'generate'])->name('teacher.report.generate');
        Route::post('teacher/report/generated', [TeacherReportController::class, 'generated'])->name('teacher.report.generated');

    });

    Route::middleware('admin')->group(function(){ 
        Route::get('dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::resource('teacher', TeacherController::class);
        Route::resource('classes', ClassesController::class);
        Route::resource('student', StudentController::class); 
    }); 

});


Route::get('test', function(Request $request, StudentClassesRepository $studentClassesRepository){
    

    return  Attendance::count();
 
});
 