<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Google\Client;
use Google\Service\Sheets;
use App\Models\TicketOrder;

class GoogleSheetController extends Controller
{
    public function export()
    {
        $spreadsheetId = env('GOOGLE_SHEET_ID');
        $credentialsPath = base_path(env('GOOGLE_APPLICATION_CREDENTIALS'));

        // Cek apakah file kredensial ada
        if (!file_exists($credentialsPath)) {
            Log::error("File credentials tidak ditemukan di path: $credentialsPath");
            return back()->with('error', 'File credentials.json tidak ditemukan.');
        }

        // Inisialisasi Google Client
        $client = new Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope(Sheets::SPREADSHEETS);
        $client->setAccessType('offline');

        $service = new Sheets($client);

        // Ambil data dari database
        $orders = TicketOrder::with('event')->get();

        $values = [
            ['ID', 'Tanggal Order', 'Nama', 'Identitas', 'Nomor Identitas', 'Email', 'No WhatsApp', 'Event', 'Kode QR', 'Status']
        ];

        foreach ($orders as $order) {
            $values[] = [
                $order->id,
                $order->created_at->format('Y-m-d H:i:s'),
                $order->name,
                $order->identity_type,
                $order->identity_number,
                $order->email,
                $order->whatsapp,
                $order->event->title ?? '-',
                $order->qrcode,
                ucfirst($order->status),
            ];
        }

        // Persiapkan body data untuk dikirim ke Sheet
        $body = new Sheets\ValueRange([
            'values' => $values
        ]);

        try {
            // Hapus data sebelumnya agar tidak tumpang tindih
            $service->spreadsheets_values->clear($spreadsheetId, 'Sheet1', new Sheets\ClearValuesRequest());

            // Kirim data ke Google Sheet
            $service->spreadsheets_values->update(
                $spreadsheetId,
                'Sheet1!A1',
                $body,
                ['valueInputOption' => 'RAW']
            );

            // Redirect langsung ke halaman Google Sheet
            return redirect()->away("https://docs.google.com/spreadsheets/d/$spreadsheetId/edit");

        } catch (\Exception $e) {
            Log::error('Gagal ekspor ke Google Sheets: ' . $e->getMessage());
            return back()->with('error', 'Gagal menulis ke Google Sheets.');
        }
    }
}
