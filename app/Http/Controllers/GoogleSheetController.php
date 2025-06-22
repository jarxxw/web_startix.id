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
        $credentialsPath = storage_path('app/google/credentials.json');

        if (!file_exists($credentialsPath)) {
            Log::error("File credentials tidak ditemukan di path: $credentialsPath");
            return back()->with('error', 'File credentials.json tidak ditemukan.');
        }

        $client = new Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope(Sheets::SPREADSHEETS);
        $client->setAccessType('offline');

        $service = new Sheets($client);

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

        $body = new Sheets\ValueRange([
            'values' => $values
        ]);

        try {
            $service->spreadsheets_values->clear($spreadsheetId, 'Sheet1', new Sheets\ClearValuesRequest());
            $service->spreadsheets_values->update(
                $spreadsheetId,
                'Sheet1!A1',
                $body,
                ['valueInputOption' => 'RAW']
            );

            // Simpan URL Google Sheet ke session
            session()->flash('success', 'Data berhasil diekspor ke Google Sheets.');
            session()->flash('sheet_url', "https://docs.google.com/spreadsheets/d/$spreadsheetId/edit");

            return redirect()->route('admin.tickets.index');

        } catch (\Exception $e) {
            Log::error('Gagal ekspor ke Google Sheets: ' . $e->getMessage());
            return back()->with('error', 'Gagal menulis ke Google Sheets.');
        }
    }
}
