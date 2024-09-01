<?php

namespace App\Repositories;

use App\Models\Classes;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ClassesRepository
{
    private $classes;

    public function __construct(Classes $classes)
    {
        $this->classes = $classes;
    }

    public function index($search , $academic_year)
    {
        return $this->classes
                    ->when($search, function(Builder $query, $value){
                           $query->where('Subject', 'LIKE', '%'. $value .'%'); 
                     })
                    ->where('academic_year', $academic_year)
                    ->with(['user' => function ($query) {
                        $query->where('role', 'teacher');
                     }])
                     ->whereHas('user', function ($query) {
                        $query->where('role', 'teacher');
                     })
                     ->orderByDesc('id')
                     ->paginate(12)
                     ->withQueryString();
    }

    public function store($data)
    {
        return $this->classes->create($data);
    }
    
    public function find($id)
    {
        return $this->classes->find($id);
    }

    public function show($id)
    {
        return $this->classes->where('id', $id)->with('user')->get();
    }

    public function update($data, $id)
    {
        return $this->classes->find($id)->update($data);
    }

    public function classes($id, $academic_year)
    {
        return $this->classes
                    ->where('user_id', $id)
                    ->where('academic_year', $academic_year)
                    ->get();
    }
    
}
