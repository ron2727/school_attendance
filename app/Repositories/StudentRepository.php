<?php

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;

class StudentRepository
{
    private $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function index($search)
    {
        return $this->student 
                    ->when($search, function(Builder $query, $value){
                       $query->where('firstName', 'LIKE', '%'. $value .'%')
                             ->orWhere('lastName', 'LIKE', '%'. $value .'%')
                             ->orWhere('gender', 'LIKE', '%'. $value .'%');  
                   })  
                   ->orderByDesc('id')
                   ->paginate(12)
                   ->withQueryString();
    }

    public function store($data)
    {
        return $this->student->create($data);
    }

    public function find($id)
    {
        return $this->student->withTrashed()->find($id);
    }

    public function update($data, $id)
    {
        
        return $this->student
                    ->find($id)
                    ->update($data); 
    }

    public function count(){
        
        return $this->student->count();
    }

    public function trash($id)
    {
       $this->student->find($id)->delete();
    }

    public function restore($id)
    {
       $this->student->withTrashed()->find($id)->restore();
    }
}
