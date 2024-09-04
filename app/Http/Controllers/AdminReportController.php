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

        $generated = $this->generateReportServices->generateAdminReport($request->input('search')); 

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
