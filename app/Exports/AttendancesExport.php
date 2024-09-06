<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendancesExport implements FromView
{
    
    public function __construct(protected $path, protected $data){ }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view($this->path, $this->data);
    } 
}
