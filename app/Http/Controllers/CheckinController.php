<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketOrder;
use App\Models\Checkin;
use Carbon\Carbon;

class CheckinController extends Controller
{
    public function checkin(Request $request)
    {
        $kodeUnik = $request->input('kode_unik');

        // Cari tiket berdasarkan QR code
        $ticket = TicketOrder::where('qrcode', $kodeUnik)->first();

        if (!$ticket) {
            return response()->json(['message' => 'QR Code tidak ditemukan.'], 404);
        }

        // Cek apakah sudah pernah check-in dengan QR yang sama untuk event yang sama
        $sudahCheckin = Checkin::where('identity_number', $ticket->identity_number)
                               ->where('event_id', $ticket->event_id)
                               ->exists();

        if ($sudahCheckin) {
            return response()->json(['message' => 'Tiket ini sudah digunakan untuk check-in.'], 400);
        }

        // Simpan data checkin
        Checkin::create([
            'event_id' => $ticket->event_id,
            'name' => $ticket->name,
            'identity_number' => $ticket->identity_number,
            'jam_checkin' => now(), // waktu saat ini
            'status' => 'valid',
        ]);

        return response()->json([
            'message' => 'Check-in berhasil',
            'nama' => $ticket->name,
            'event_id' => $ticket->event_id,
            'jam_checkin' => now()->toDateTimeString()
        ]);
    }
    public function dataCheckins()
{
    // Load checkins + relasi ke events (title-nya)
    $checkins = Checkin::with('event:id,title')->get();

    return view('admin.layouts.checkins', compact('checkins'));
}
}
