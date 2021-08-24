<?php

namespace App\Exports;

use App\TravelPass;
use App\Workplace;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class ReportExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('travelpasses.report', [
            'travelpasses' => TravelPass::all(),
            'workplaces' => Workplace::all()
        ]);
    }
}
