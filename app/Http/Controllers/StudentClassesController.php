<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentClassesRequest;
use App\Repositories\StudentClassesRepository;
use Illuminate\Http\Request;

class StudentClassesController extends Controller
{
    public function __construct(protected StudentClassesRepository $studentClassesRepository) {}
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->studentClassesRepository->storeStudents($request->all());

        return back()->with('success', 'Student/s successfully added in the class');
    } 
}
