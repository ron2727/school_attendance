<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentClassesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherReportController;
use App\Http\Controllers\UserController;
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
        Route::get('teacher/dashboard', [DashboardController::class, 'teacher'])->name('teacher.dashboard');

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

        Route::get('teacher/profile', [ProfileController::class , 'index'])->name('teacher.profile');
        Route::put('teacher/profile', [ProfileController::class , 'update'])->name('teacher.profile.update');
        Route::put('teacher/profile/change-password', [ProfileController::class , 'changePassword'])->name('teacher.change-password');
    });

    Route::middleware('admin')->group(function(){ 
        Route::get('dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::resources([
            'teacher' => TeacherController::class,
            'classes' => ClassesController::class,
            'student' => StudentController::class
        ]);  
        Route::get('admin/profile', [ProfileController::class , 'index'])->name('admin.profile');
        Route::put('admin/profile', [ProfileController::class , 'update'])->name('admin.update');
        Route::put('admin/profile/change-password', [ProfileController::class , 'changePassword'])->name('admin.change-password');
    }); 

});


Route::get('test', function(Request $request){
    

    return  Classes::where('user_id', 2) 
                   ->where('academic_year', date('Y'))
                   ->with(['attendance' => function ($query) {
                         $query->where('status', 'absent')
                               ->where('date', date('Y-m-d', strtotime('2024-09-03')));
                    }])->get()
                    ->map(function($item) { 
                        return [
                            'subject' => $item['subject'].'('.$item['grade_section'].')',
                            'total' => count($item['attendance'])
                        ];
                     })->reduce(function($carry, $item){
                         
                         $carry['subject']->push($item['subject']);
                         $carry['total']->push($item['total']);
                         return $carry;
                     }, ['subject' => collect([]), 'total' => collect([])]);
 
});
  