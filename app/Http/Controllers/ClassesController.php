<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassesRequest;
use App\Models\Classes;
use App\Repositories\ClassesRepository;
use App\Repositories\TeacherRepository;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    protected $classesRepository;
    protected $teacherRepository;

    public function __construct(ClassesRepository $classesRepository, TeacherRepository $teacherRepository) {
        $this->classesRepository = $classesRepository;
        $this->teacherRepository = $teacherRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $academic_year = $request->input('academic_year');
        if (!$academic_year) {
            $academic_year = date('Y');
        }

        $classes = $this->classesRepository->index($request->input('search'), $academic_year);

        return inertia('Admin/Classes/Index', [
                                                'classes' => $classes,
                                                'filters' => [
                                                    'search' => $request->input('search'),
                                                    'academic_year' =>  $academic_year
                                                ]
                                              ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    { 
        $teachers = $this->teacherRepository->index($request->input('search'));

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
    public function destroy(Classes $classes)
    {
        //
    }
}
