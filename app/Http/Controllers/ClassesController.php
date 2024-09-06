<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassesRequest;
use App\Models\Classes; 
use App\Repositories\ClassesRepository;
use App\Repositories\StudentClassesRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use Illuminate\Http\Request;

class ClassesController extends Controller
{ 

    public function __construct(protected ClassesRepository $classesRepository, 
                                protected TeacherRepository $teacherRepository,
                                protected StudentRepository $studentRepository,
                                protected StudentClassesRepository $studentClassesRepository) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $academic_year = $request->input('academic_year');
        if (!$academic_year) {
            $academic_year = date('Y');
        }

        $classes = $this->classesRepository->index($request->input('search'), $academic_year, $request->input('trashed'));

        return inertia('Admin/Classes/Index', [
                                                'classes' => $classes,
                                                'filters' => [
                                                    'search' => $request->input('search'),
                                                    'academic_year' =>  $academic_year,
                                                    'trashed' => $request->input('trashed')
                                                ]
                                              ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    { 
        $teachers = $this->teacherRepository->randomOrder($request->input('search'));

        return inertia('Admin/Classes/Create', ['teachers' => $teachers, 'filters' => $request->input('search')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassesRequest $request)
    {
        $this->classesRepository->store($request->validated());

        return redirect()
               ->route('classes.index')
               ->with('success', 'Class successfully added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classes $classes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $teachers = $this->teacherRepository->index($request->input('search'));
        $teacherClass = $this->classesRepository->show($id);
                 
        return inertia('Admin/Classes/Edit', [
                                                 'teacherClass' => $teacherClass[0],
                                                 'teachers' => $teachers,
                                                 'filters' => $request->input('search')
                                             ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassesRequest $request, string $id)
    {
        $this->classesRepository->update($request->validated(), $id);

        return redirect()
               ->route('classes.edit', ['class' => $id])
               ->with('success', 'Class updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->classesRepository->trash($id);

        return back()->with('success', 'Class successfully deleted');
    }

    public function restore(string $id)
    {
        $this->classesRepository->restore($id);

        return back()->with('success', 'Class restored');
    }

    public function classes(Request $request)
    {
        $academic_year = $request->input('academic_year');
        if (!$academic_year) {
            $academic_year = date('Y');
        }
        
        $classes = $this->classesRepository->classes($request->user()->id, $academic_year);

        return inertia('Teacher/Classes/Index', ['classes' => $classes]);
    }

    public function classStudents(Request $request, string $class_id)
    {  
        $students = $this->studentRepository->randomOrder($request->input('search'));
        $teacherClass = $this->classesRepository->find($class_id);
        $studentsOfClasses = $this->studentClassesRepository->studentsOfClass($class_id);

        return inertia('Teacher/Classes/Students', [ 
                                                    'teacherClass' => $teacherClass,
                                                    'studentsClass' => $studentsOfClasses,
                                                    'students' => $students,
                                                    'filters' => $request->input('search')
                                                   ]);
    }
}
