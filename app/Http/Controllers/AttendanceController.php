<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Repositories\AttendanceRepository;
use App\Repositories\ClassesRepository;
use App\Repositories\StudentClassesRepository;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function __construct(protected AttendanceRepository $attendanceRepository,
                                protected ClassesRepository $classesRepository,
                                protected StudentClassesRepository $studentClassesRepository) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        
        $classes = $this->classesRepository->classes($request->user()->id, date('Y'));

        return inertia('Teacher/Attendance/Classes', ['classes' => $classes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->attendanceRepository->store($request->input());

        return back()->with('success', 'The attendance for this class has been recorded!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->attendanceRepository->update($request->input());

        return back()->with('success', 'The class attendance has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function classStudents($id)
    {   
        $teacherClass = $this->classesRepository->find($id);
        $studentsOfClasses = $this->studentClassesRepository->studentsOfClass($id);
        $isClassHasAttendance = $this->attendanceRepository->isClassHasAttendance($id);
        $attendances = $this->attendanceRepository->findStudentsOfClass($id);

        return inertia('Teacher/Attendance/Students', [  
                                                    'teacherClass' => $teacherClass,
                                                    'studentsClass' => $studentsOfClasses, 
                                                    'isClassHasAttendance' => $isClassHasAttendance,
                                                    'attendances' => $attendances,
                                                    'dateToday' => date('M d, Y')
                                                   ]);
    }
}
