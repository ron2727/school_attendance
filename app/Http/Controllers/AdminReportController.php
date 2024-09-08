<?php

namespace App\Http\Controllers;

use App\Services\ExportPdf;
use App\Services\GenerateReportServices;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    
    public function __construct(protected GenerateReportServices $generateReportServices) { } 

    public function index(Request $request)
    { 
        $current_date = now('Asia/Manila');
        if ($request->has('search')) {
            $current_date = $request->input('search');
        }
        $generated = $this->generateReportServices->generateAdminReport($current_date); 

        return inertia('Admin/Report/Generate', [
                                                     'generated' => $generated, 
                                                     'filters' => $request->input('search')
                                                  ]);
    }

    public function generate(Request $request)
    {   
        if ($request->input('export_type') === 'pdf') {
            $export_type = new ExportPdf();
        }
    
        return $this->generateReportServices->attendanceDailyReportAdmin($request->input('date'), $export_type);
    }
}
