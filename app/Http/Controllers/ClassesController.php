<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Repositories\ClassesRepository;
use App\Repositories\TeacherRepository;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    protected $classesRepository;

    public function __construct(ClassesRepository $classesRepository) {
        $this->classesRepository = $classesRepository;
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Classes $classes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classes $classes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classes $classes)
    {
        //
    }
}
