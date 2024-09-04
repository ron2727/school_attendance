<?php

use App\Http\Controllers\AdminReportController;
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
use App\Services\GenerateReportServices;
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
        Route::get('report', [AdminReportController::class, 'index'])->name('admin.report.index');
        Route::post('report/generate', [AdminReportController::class, 'generate'])->name('admin.report.generate'); 

        Route::get('profile', [ProfileController::class , 'index'])->name('admin.profile');
        Route::put('profile', [ProfileController::class , 'update'])->name('admin.update');
        Route::put('profile/change-password', [ProfileController::class , 'changePassword'])->name('admin.change-password');
    }); 

});


Route::get('test', function(Request $request, GenerateReportServices $generateReport){
    

    return $generateReport->generateAdminReport('2024-09-03');
 
});

Route::get('tests', function(Request $request, GenerateReportServices $generateReport){
    

    return  User::where('role', 'teacher')->
                 with(['classes' => function($query){
                     $query->where('academic_year', date('Y'));
                 }])->
                 whereHas('classes', function($query){
                    $query->where('academic_year', date('Y'));
                 })->get()
                 ->map(function($item){
                       
                    foreach ($item['classes'] as $key => $class) {
                       $item['classes'][$key]['students'] = StudentClasses::where('class_id', $class['id'])->count();
                       $item['classes'][$key]['present_total'] = Attendance::where('class_id', $class['id'])
                                                                            ->where('date', date('Y-m-d', strtotime('2024-09-03')))
                                                                            ->where('status', 'present')
                                                                            ->count();
                       $item['classes'][$key]['absent_total'] = Attendance::where('class_id', $class['id'])
                                                                            ->where('date', date('Y-m-d', strtotime('2024-09-03')))
                                                                            ->where('status', 'absent')
                                                                            ->count();                                                   
                    }
                       $item['presents_overall_total'] = collect($item['classes'])
                                                         ->reduce(fn($carry, $item) => $carry + $item['present_total'], 0);
                       $item['absents_overall_total'] = collect($item['classes'])
                                                         ->reduce(fn($carry, $item) => $carry + $item['absent_total'], 0);
                       $item['students_overall_total'] = collect($item['classes'])
                                                         ->reduce(fn($carry, $item) => $carry + $item['students'], 0); 
                       $item['classes'] = count($item['classes']);

                       return $item;
                 });
 
});
  
// return  User::where('role', 'teacher')->
//                  with(['classes' => function($query){
//                      $query->where('academic_year', date('Y'));
//                  }])->
//                  whereHas('classes', function($query){
//                     $query->where('academic_year', date('Y'));
//                  })->get()
//                  ->map(function($item){
                       
//                     foreach ($item['classes'] as $key => $class) {
//                        $item['classes'][$key]['students'] = StudentClasses::where('class_id', $class['id'])->count();
//                        $item['classes'][$key]['present_total'] = Attendance::where('class_id', $class['id'])
//                                                                             ->where('date', date('Y-m-d', strtotime('2024-09-4')))
//                                                                             ->where('status', 'present')
//                                                                             ->count();
//                        $item['classes'][$key]['absent_total'] = Attendance::where('class_id', $class['id'])
//                                                                             ->where('date', date('Y-m-d', strtotime('2024-09-4')))
//                                                                             ->where('status', 'absent')
//                                                                             ->count();                                                   
//                     }
//                        $item['presents_overall_total'] = collect($item['classes'])
//                                                          ->reduce(fn($carry, $item) => $carry + $item['present_total'], 0);
//                        $item['absents_overall_total'] = collect($item['classes'])
//                                                          ->reduce(fn($carry, $item) => $carry + $item['absent_total'], 0);
//                        $item['students_overall_total'] = collect($item['classes'])
//                                                          ->reduce(fn($carry, $item) => $carry + $item['students'], 0); 
//                        $item['classes'] = count($item['classes']);

//                        return $item;
//                  });