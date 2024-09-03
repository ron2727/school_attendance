<?php

namespace App\Http\Controllers;

use App\Repositories\AttendanceRepository;
use App\Repositories\ClassesRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
         protected AttendanceRepository $attendanceRepository, 
         protected TeacherRepository $teacherRepository,
         protected StudentRepository $studentRepository,
         protected ClassesRepository $classesRepository
    ) {}

    public function admin()
    {
        $chart_data = $this->attendanceRepository->dailyAttendanceTotal();
        $teacher_total = $this->teacherRepository->count();
        $classes_total = $this->classesRepository->count();
        $student_total = $this->studentRepository->count();
        
        return inertia('Admin/Dashboard', [
                                             'chartData' => $chart_data,
                                             'teacherTotal' => $teacher_total,
                                             'classesTotal' => $classes_total,
                                             'studentTotal' => $student_total,
                                          ]);
    }
}
