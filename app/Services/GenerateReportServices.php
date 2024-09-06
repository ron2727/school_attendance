<?php

namespace App\Services;

use App\Models\StudentClasses;
use App\Models\User;
use App\Repositories\AttendanceRepository;
use App\Repositories\ClassesRepository;
use App\Repositories\StudentClassesRepository;

class GenerateReportServices
{
    public function __construct(
         protected AttendanceRepository $attendanceRepository,
         protected ClassesRepository $classesRepository,
         protected StudentClassesRepository $studentClassesRepository,
    ){ }

    public function attendanceDailyReport(array $filter, ExportFileInferface $exportFile, string $path)
    {
         $attendances = $this->attendanceRepository->findAttendanceRecord($filter['class_id'], $filter['date']);
         $class = $this->classesRepository->show($filter['class_id']);

         return $exportFile->export($path, [
                                             'attendances' => $attendances,
                                             'class' => $class[0],
                                             'date_attendance' => date('F d, Y', strtotime($filter['date']))
                                           ]);
    }

    public function attendanceDailyReportAdmin(string $date, ExportFileInferface $exportFile)
    {
         $attendances = $this->generateAdminReport($date); 

         return $exportFile->export('report.template.pdf.DailyAttendanceReportAdmin', [
                                                                                   'attendances' => $attendances, 
                                                                                   'date_attendance' => date('F d, Y', strtotime($date))
                                                                                 ]);
    }

    public function generateAdminReport(string $date)
    { 
       return  User::where('role', 'teacher')
                   ->with(['classes' => function($query) use($date){
                        $query->where('academic_year', date('Y' , strtotime($date)));
                   }])
                   ->whereHas('classes', function($query) use($date){
                        $query->where('academic_year', date('Y' , strtotime($date)));
                   })
                   ->get()
                   ->map(function($item) use($date){
                       
                       foreach ($item['classes'] as $key => $class) {
                          $item['classes'][$key]['students'] = $this->studentClassesRepository->find('class_id', $class['id'])->count();
                          $item['classes'][$key]['present_total'] =  $this->attendanceRepository->findAttendanceRecordWithStatus($class['id'], $date, 'present')->count();
                          $item['classes'][$key]['absent_total'] = $this->attendanceRepository->findAttendanceRecordWithStatus($class['id'], $date, 'absent')->count();
                       }
                    
                       $item['presents_overall_total'] = collect($item['classes'])->reduce(fn($carry, $item) => $carry + $item['present_total'], 0);
                       $item['absents_overall_total'] = collect($item['classes'])->reduce(fn($carry, $item) => $carry + $item['absent_total'], 0);
                       $item['students_overall_total'] = collect($item['classes'])->reduce(fn($carry, $item) => $carry + $item['students'], 0); 

                       return $item;
                   });
    }
}
