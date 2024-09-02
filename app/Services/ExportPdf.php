<?php

namespace App\Services;

use Spatie\LaravelPdf\Facades\Pdf;

class ExportPdf implements ExportFileInferface
{
    public function __construct()
    {
        //
    }

    public function export($path, $data)
    {
        return Pdf::view($path, $data)
                  ->format('A4')
                  ->margins(25.4, 25.4, 25.4, 25.4);
    }  
}
