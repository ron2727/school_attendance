<?php

namespace App\Repositories;

use App\Models\Classes; 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ClassesRepository
{ 

    public function __construct(
        private Classes $classes, 
        private StudentClassesRepository $studentClassesRepository
    ){}

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
        return $this->classes->withTrashed()->where('id', $id)->with('user')->get();
    }

    public function update($data, $id)
    {
        return $this->classes
                    ->withTrashed()
                    ->find($id)
                    ->update($data);
    }

    public function classes($id, $academic_year)
    {
        return $this->classes
                    ->where('user_id', $id)
                    ->where('academic_year', $academic_year)
                    ->get();
    }
    
    public function count(){
        
        return $this->classes->count();
    }

    public function teacherClassesCount(){
        
        return $this->classes
                    ->where('user_id', Auth::user()->id)
                    ->count();
    } 

    public function studentsClassesCount()
    {
        return $this->classes
                    ->where('user_id', Auth::user()->id) 
                    ->get() 
                    ->map(function($item) {
                        $studentClasses = $this->studentClassesRepository->find('class_id', $item['id']);  
                        return $studentClasses->count() ?? 0;
                    })->reduce(fn($carry, $item) => $carry + $item);
    }

    public function absentsEachClass()
    {
        return  $this->classes
                     ->where('user_id', Auth::user()->id) 
                     ->where('academic_year', date('Y'))
                     ->with(['attendance' => function ($query) {
                         $query->where('status', 'absent')
                               ->where('date', date('Y-m-d', strtotime(Carbon::now()->timezone('Asia/Manila'))));
                      }])->get()
                     ->map(function($item) { 
                        return [
                            'subject' => $item['subject'].' ('.$item['grade_section'].')',
                            'total' => count($item['attendance'])
                        ];
                     })->reduce(function($carry, $item){
                         
                         $carry['subjects']->push($item['subject']);
                         $carry['totals']->push($item['total']);
                         return $carry;
                     }, ['subjects' => collect([]), 'totals' => collect([])]);
    }

    public function trash($id)
    {
       $this->classes->find($id)->delete();
    }

    public function restore($id)
    {
       $this->classes->withTrashed()->find($id)->restore();
    }
}
