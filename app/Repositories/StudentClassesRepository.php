<?php

namespace App\Repositories;

use App\Models\StudentClasses;
use Illuminate\Support\Facades\DB;

class StudentClassesRepository
{
    public function __construct(public StudentClasses $studentClasses) { }

    public function store($data)
    {
        return $this->studentClasses->create($data);
    }

    public function studentsOfClass($class_id)
    {
        return DB::table('students_classes')
                  ->join('students', 'students_classes.student_id', '=', 'students.id')
                  ->select('students.*')
                  ->where('class_id', $class_id)
                  ->where('deleted_at', null)
                  ->get();
    }

    public function find($column, $value){
       
        return $this->studentClasses->where($column, $value)->get();
    }
}
