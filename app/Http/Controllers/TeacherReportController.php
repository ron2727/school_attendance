<?php

namespace App\Http\Controllers;

use App\Repositories\AttendanceRepository;
use App\Repositories\ClassesRepository;
use App\Services\ExportExcel;
use App\Services\ExportPdf;
use App\Services\GenerateReportServices;
use Illuminate\Http\Request;

class TeacherReportController extends Controller
{
    public function __construct(protected ClassesRepository $classesRepository,
                                protected AttendanceRepository $attendanceRepository,
                                protected GenerateReportServices $generateReportServices) { }

    public function index(Request $request)
    { 

        $classes = $this->classesRepository->classes($request->user()->id, date('Y'));

        return inertia('Teacher/Report/Index', ['classes' => $classes]);
    }

    public function generate(Request $request, string $class_id)
    { 

        $generated = $this->attendanceRepository->findAttendanceRecord($class_id, $request->input('search'));
        $teacherClass = $this->classesRepository->find($class_id);

        return inertia('Teacher/Report/Generate', [
                                                     'generated' => $generated,
                                                     'teacherClass' => $teacherClass,
                                                     'filters' => $request->input('search')
                                                  ]);
    }

    public function generated(Request $request)
    {  
        $filters = [
                     'class_id' => $request->input('class_id'),
                     'date' => $request->input('date'), 
                   ];

        if ($request->input('export_type') === 'pdf') {
            $export_type = new ExportPdf();
            $path = 'report.template.pdf.DailyAttendanceReport';
        }

        if ($request->input('export_type') === 'excel') {
            $export_type = new ExportExcel();
            $path = 'report.template.excel.DailyAttendanceRecord';
        }

        return $this->generateReportServices->attendanceDailyReport($filters, $export_type, $path);
    }
}
