<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\TicketOrderController;
use App\Http\Controllers\Admin\AdminController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\GoogleSheetController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --------------------
// Guest / Public Routes
// --------------------
Route::get('/', [EventController::class, 'userHome'])->name('user.dashboard');
Route::get('/events', [EventController::class, 'userDashboard'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{event}/order', [EventController::class, 'orderForm'])->name('events.order');
Route::post('/events/{event}/order', [EventController::class, 'processOrder'])->name('events.order.process');
Route::get('/events/{event}/payment', [EventController::class, 'paymentForm'])->name('events.payment');
Route::post('/events/{event}/payment', [EventController::class, 'processPayment'])->name('events.payment.process');

// API for charts
Route::get('/api/chart-data', [EventController::class, 'getChartData']);

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin events viewable by guests
Route::get('/admin/events', [EventController::class, 'index'])->name('admin.events.index');
Route::get('/admin/acara', [EventController::class, 'adminEvents'])->name('admin.acara');
Route::get('/admin/acara/on-going', [TicketController::class, 'active'])->name('admin.acara.aktif_event');
Route::get('/admin/acara/done', [TicketController::class, 'completed'])->name('admin.acara.done_event');



// --------------------
// Admin (with auth middleware)
// --------------------
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('dashboard', [EventController::class, 'adminDashboard'])->name('dashboard');
    Route::get('super/dashboard', [EventController::class, 'superadminDashboard'])->name('super.dashboard');


    // Ticket Order Routes
    Route::resource('tickets', TicketOrderController::class)->only(['index', 'show', 'update','destroy']);
    Route::get('tickets/{order}/download-qr', [TicketOrderController::class, 'downloadQrExcel'])->name('tickets.download-qr');
    Route::get('/checkins', [CheckinController::class,'dataCheckins'])->name('checkins');

    // Admin and Event Management
    Route::resource('admins', AdminController::class);
    Route::resource('events', EventController::class);
    Route::get('events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('events', [EventController::class, 'store'])->name('events.store');

    // QR download (manual)
    Route::get('ticket/{id}/download-qr', function ($id) {
        $order = \App\Models\TicketOrder::findOrFail($id);
        return response(QrCode::format('png')->size(300)->generate($order->kode_tiket ?? $order->id))
            ->header('Content-Type', 'image/png');
    })->name('ticket.qr.download');
});
Route::get('tickets/export-excel', [TicketOrderController::class, 'exportConfirmedExcel'])->name('tickets.export-excel');

// Optional: Export all tickets (non-admin, if needed)
Route::get('/export-tickets', [ExportController::class, 'export'])->name('export.tickets');
Route::get('/order-success/{id}', [TicketOrderController::class, 'success'])->name('order.success');

Route::get('/export-sheet', [GoogleSheetController::class, 'export'])->name('tickets.export-sheet');




