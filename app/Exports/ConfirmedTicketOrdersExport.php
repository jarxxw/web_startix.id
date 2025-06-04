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
                    'Tanggal Order' => $order->created_at->format('Y-m-d H:i:s'),
                    'Nama' => $order->name,
                    'Identitas'=>$order->identity_type,
                    'Nomor Identitas'=>$order->identity_number,
                    'Email' => $order->email,
                    'No WhatsApp' => $order->whatsapp,
                    'Event' => $order->event->title ?? '-',
                    'Kode QR'=>$order->qrcode,
                    'Status' => ucfirst($order->status),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal Order',
            'Nama',
            'Identitas',
            'Nomor Identitas',
            'Email',
            'No WhatsApp',
            'Event',
            'Kode QR',
            'Status',
        ];
    }
}
