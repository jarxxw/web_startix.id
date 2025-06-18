<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketOrder;

class CheckinController extends Controller
{
    public function checkin(Request $request)
    {
        $kodeUnik = $request->input('kode_unik');

        // Cari kode di kolom 'qrcode' pada tabel ticket_orders
        $ticket = TicketOrder::where('qrcode', $kodeUnik)->first();

        if ($ticket) {
            return response()->json([
                'status' => 'success',
                'message' => 'Check-in berhasil',
                'data' => $ticket
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Check-in gagal: kode tidak ditemukan'
            ], 404);
        }
    }
}
