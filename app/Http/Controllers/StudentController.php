<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Repositories\StudentRepository;
use Illuminate\Http\Request;

class StudentController extends Controller
{ 

    public function __construct(protected StudentRepository $studentRepository) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = $this->studentRepository->index($request->input('search'), $request->input('trashed'));

        return inertia('Admin/Student/Index', ['students' => $students, 'filters' => [
                                                                             'search' => $request->input('search'),
                                                                              'trashed' => $request->input('trashed'),
                                                                         ]]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Student/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        $this->studentRepository->store($request->validated());

        return redirect()
               ->route('student.index')
               ->with('success', 'New student was successfully created!');
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = $this->studentRepository->find($id);

        return inertia('Admin/Student/Edit', ['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, string $id)
    {
        $this->studentRepository->update($request->validated(), $id);

        return back()->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->studentRepository->trash($id);

        return back()->with('success', 'Student successfully deleted');
    }

    public function restore(string $id)
    {
        $this->studentRepository->restore($id);

        return back()->with('success', 'Student restored');
    }
}
