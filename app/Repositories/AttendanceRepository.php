<?php

namespace App\Repositories;

use App\Models\Attendance;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceRepository
{
    public function __construct(private Attendance $attendance) {  }

    public function findStudentsOfClass($class_id)
    {
       return $this->attendance
                   ->where('class_id', $class_id)
                   ->where('date', now('Asia/Manila')->format('Y-m-d'))
                   ->get();
    }

    public function store($data)
    {
        foreach ($data['students'] as $user_id => $status) {
           $this->attendance->create([
               'class_id' => $data['class_id'],
               'student_id' => $user_id,
               'status' => $status,
               'date' => now('Asia/Manila')->format('Y-m-d')
           ]);
        }
 
    }

    public function update($data)
    {
        foreach ($data['students'] as $user_id => $status) {
           $this->attendance 
                ->updateOrInsert([ 
                    'class_id' => $data['class_id'],
                    'student_id' => $user_id,
                    'date' => now('Asia/Manila')->format('Y-m-d')
                ],
                ['status' => $status]);
        }
 
    }

    public function isClassHasAttendance($class_id)
    {
       return $this->attendance
                   ->where('class_id', $class_id)
                   ->where('date', now('Asia/Manila')->format('Y-m-d'))
                   ->count() > 0;
    }

    public function findAttendanceRecord($class_id, $date)
    {
        return $this->attendance 
                    ->where('class_id', $class_id)
                    ->where('date', $date)
                    ->with('student') 
                    ->whereHas('student', function($query){
                        $query->where('deleted_at', NULL);
                     })
                    ->paginate(8) 
                    ->withQueryString();
    }

    public function findAttendanceAllRecord($class_id, $date)
    {
        return $this->attendance 
                    ->where('class_id', $class_id)
                    ->where('date', $date)
                    ->with('student') 
                    ->whereHas('student', function($query){
                        $query->where('deleted_at', NULL);
                     })
                    ->get();
    }

    public function dailyAttendanceTotal()
    {
        return $this->attendance
                    ->select(DB::raw('count(*) as total, status'))
                    ->where('date', date('Y-m-d', strtotime(Carbon::now()->timezone('Asia/Manila'))))
                    ->groupBy('status')
                    ->get()
                    ->reduce(function($carry, $item){ 
                        $carry['status']->push(ucfirst($item['status']));
                        $carry['totals']->push($item['total']);
   
                        return $carry;
                    }, ['status' => collect([]), 'totals' => collect([])]);
    }

    public function findAttendanceRecordWithStatus($class_id, $date, $status)
    {
        return $this->attendance
                    ->where('class_id', $class_id)
                    ->where('date', $date)
                    ->where('status', $status)
                    ->get();
    }
}
