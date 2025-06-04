<?php

namespace App\Exports;

use App\Models\TicketOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConfirmedTicketOrdersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return TicketOrder::with('event')
            ->where('status', 'confirmed')
            ->get()
            ->map(function ($order) {
                return [
                    'ID' => $order->id,
                    'Nama' => $order->name,
                    'Email' => $order->email,
                    'No WhatsApp' => $order->whatsapp,
                    'Event' => $order->event->title ?? '-',
                    'Status' => ucfirst($order->status),
                    'Tanggal Order' => $order->created_at->format('Y-m-d H:i:s'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'No WhatsApp',
            'Event',
            'Status',
            'Tanggal Order',
        ];
    }
}
