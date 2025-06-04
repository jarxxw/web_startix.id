<?php

namespace App\Exports;

use App\Models\TicketOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketOrdersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return TicketOrder::all(['id', 'name', 'email', 'whatsapp', 'status', 'created_at']);
    }

    public function headings(): array
    {
        return ['ID', 'Nama', 'Email', 'No WhatsApp', 'Status', 'Tanggal Order'];
    }
}
