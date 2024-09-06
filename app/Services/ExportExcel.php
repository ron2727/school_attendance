<?php

namespace App\Services;

use App\Exports\AttendancesExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcel implements ExportFileInferface
{
    public function __construct()
    {
        //
    }

    public function export($path, $data)
    { 
        $file_name =  'DailyAttendanceRecord_'.$data['date_attendance'].'.xlsx';
        
        return Excel::download(new AttendancesExport($path, $data), $file_name);
    }  
}
