<?php

namespace App\Repositories;

use App\Models\Attendance;

class AttendanceRepository
{
    public function __construct(private Attendance $attendance) {  }

    public function findStudentsOfClass($class_id)
    {
       return $this->attendance
                   ->where('class_id', $class_id)
                   ->where('date', date('Y-m-d'))
                   ->get();
    }

    public function store($data)
    {
        foreach ($data['students'] as $user_id => $status) {
           $this->attendance->create([
               'class_id' => $data['class_id'],
               'student_id' => $user_id,
               'status' => $status,
               'date' => date('Y-m-d')
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
                    'date' => date('Y-m-d')
                ],
                ['status' => $status,]);
        }
 
    }

    public function isClassHasAttendance($class_id)
    {
       return $this->attendance
                   ->where('class_id', $class_id)
                   ->where('date', date('Y-m-d'))
                   ->count() > 0;
    }
}
