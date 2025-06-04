<?php

namespace App\Http\Controllers;

use App\Exports\TicketOrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export()
    {
        return Excel::download(new TicketOrdersExport, 'daftar_tiket.xlsx');
    }
}
