<?php

namespace App\Services;

use App\Repositories\AttendanceRepository;
use App\Repositories\ClassesRepository;

class GenerateReportServices
{
    public function __construct(
         protected AttendanceRepository $attendanceRepository,
         protected ClassesRepository $classesRepository,
    ){ }

    public function attendanceDailyReport(array $filter, ExportFileInferface $exportFile)
    {
         $attendances = $this->attendanceRepository->findAttendanceRecord($filter['class_id'], $filter['date']);
         $class = $this->classesRepository->show($filter['class_id']);

         return $exportFile->export('report.template.pdf.DailyAttendanceReport', [
                                                                                   'attendances' => $attendances,
                                                                                   'class' => $class[0],
                                                                                   'date_attendance' => date('F d, Y', strtotime($filter['date']))
                                                                                 ]);
    }
}
