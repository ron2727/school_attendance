<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherRepository
{
    private $teacher;

    public function __construct(User $user)
    {
        $this->teacher = $user;
    }

    public function index($search, $trashed = '')
    {
        return $this->teacher 
                    ->when($trashed, function(Builder $query, $value){
                        if ($value === 'with') {
                            $query->withTrashed(); 
                        }
                        if ($value === 'only') {
                            $query->onlyTrashed(); 
                        }
                    })
                    ->when($search, function(Builder $query, $value){
                       $query->where('firstName', 'LIKE', '%'. $value .'%');  
                    }) 
                    ->where('role', 'teacher')
                    ->orderByDesc('id')
                    ->paginate(12)
                    ->withQueryString();
    }

    public function store($data)
    {
        return $this->teacher->create($data);
    }

    public function find($id)
    {
        return $this->teacher->withTrashed()->find($id);
    }
    
    public function update($data, $id)
    {
        
        return $this->teacher
                    ->withTrashed()
                    ->find($id)
                    ->update($data); 
    }

    public function getTeachersWithClasses($search, $academic_year)
    {
        if (!$academic_year) {
            $academic_year = date('Y');
        }

        return $this->teacher
                    ->when($search, function(Builder $query, $value){
                          $query->where('firstName', 'LIKE', '%'. $value .'%')
                                ->orWhere('lastName', 'LIKE', '%'. $value .'%');
                     })
                    ->where('role', 'teacher') 
                    ->whereHas('classes', function ($query) use ($academic_year){
                        $query->where('academic_year', $academic_year);
                    })
                    ->with(['classes' => function ($query) use ($academic_year) {
                        $query->where('academic_year', $academic_year);
                     }])
                    ->orderByDesc('id')
                    ->paginate(12)
                    ->withQueryString();
    }

    public function getTeacherClasses($academic_year)
    { 

        return $this->teacher::query()
                              ->where('id', Auth::user()->id)
                              ->where('role', 'teacher')
                              ->with(['classes' => function ($query) use ($academic_year) {
                                                         $query->where('academic_year', $academic_year);
                                                    }])
                              ->whereHas('classes', function ($query) use ($academic_year) {
                                                         $query->where('academic_year', $academic_year);
                              })
                              ->get();
    }

    public function count(){
        
        return $this->teacher 
                    ->where('role', 'teacher')
                    ->count();
    }

    public function trash($id)
    {
       $this->teacher->find($id)->delete();
    }

    public function restore($id)
    {
       $this->teacher->withTrashed()->find($id)->restore();
    }

    public function randomOrder($search)
    {
        return $this->teacher  
                    ->when($search, function(Builder $query, $value){
                       $query->where('firstName', 'LIKE', '%'. $value .'%');  
                    }) 
                    ->where('role', 'teacher')
                    ->inRandomOrder()
                    ->take(8)
                    ->get();
    }
} 