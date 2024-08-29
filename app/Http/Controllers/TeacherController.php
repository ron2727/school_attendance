<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\TeacherRepository;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    protected $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository) {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $teachers = $this->teacherRepository->index($request->input('search'));

        return inertia('Admin/Teachers/Index', ['teachers' => $teachers, 'filters' => $request->input('search')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Teachers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    { 

        $this->teacherRepository->store($request->validated());

        return redirect()
               ->route('teacher.index')
               ->with('success', 'New teacher was successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $teacher = $this->teacherRepository->find($id);

        return inertia('Admin/Teachers/Edit', ['teacher' => $teacher]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        
        $this->teacherRepository->update($request->validated(), $id);

        return back()->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
