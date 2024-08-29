<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class TeacherRepository
{
    private $teacher;

    public function __construct(User $user)
    {
        $this->teacher = $user;
    }

    public function index($search)
    {
        return User::query()
                   ->when($search, function(Builder $query, $value){
                       $query->where('firstName', 'LIKE', '%'. $value .'%')
                             ->orWhere('lastName', 'LIKE', '%'. $value .'%')
                             ->orWhere('email', 'LIKE', '%'. $value .'%');
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
        return $this->teacher->find($id);
    }
    
    public function update($data, $id)
    {
        
        return $this->teacher
               ->find($id)
               ->update($data); 
    }
}
