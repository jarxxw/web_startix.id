<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Carbon\Carbon;


class EventController extends Controller
{
    // Dashboard untuk user (tidak login)

    public function userHome()
    {
        $events = Event::latest()->take(3)->get();

        return view('user.layouts.home', compact('events'));
    }

    public function userDashboard(Request $request)
    {
        $query = Event::query();

        // Filter
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        if ($request->has('month') && $request->month != '') {
            $query->whereMonth('event_date', $request->month);
        }
        if ($request->has('year') && $request->year != '') {
            $query->whereYear('event_date', $request->year);
        }
        if ($request->has('venue') && $request->venue != '') {
            $query->where('venue', $request->venue);
        }
        $query->where('status', 'upcoming');
        $query->orderBy('event_date', 'asc');
        $events = $query->paginate(9);
        $venues = Event::select('venue')->distinct()->orderBy('venue')->pluck('venue');
        return view('user.layouts.dashboard', compact('events', 'venues'));
    }

    // Dashboard untuk admin (login & role admin)
    public function adminDashboard(Request $request)
    {
        
        $query = Event::query();
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        if ($request->has('month') && $request->month != '') {
            $query->whereMonth('event_date', $request->month);
        }
        if ($request->has('year') && $request->year != '') {
            $query->whereYear('event_date', $request->year);
        }
        if ($request->has('venue') && $request->venue != '') {
            $query->where('venue', $request->venue);
        }
        $query->where('status', 'upcoming');
        $query->orderBy('event_date', 'asc');
        $events = $query->paginate(9);
        $venues = Event::select('venue')->distinct()->orderBy('venue')->pluck('venue');
        $stats = [
            'total_events' => Event::count(),
            'tickets_sold' => TicketOrder::where('status', 'confirmed')->count(),
            'upcoming_events' => Event::where('status', 'upcoming')->count(),
            'total_revenue' => TicketOrder::where('status', 'confirmed')->with('event')->get()->sum(function ($order) {
                return $order->event->price ?? 0;
            }),
        ];
        $chartData = $this->getChartData($request);
        return view('admin.pages.dashboard.index', compact('events', 'stats', 'venues', 'chartData'));
    }
        public function superadminDashboard(Request $request)
    {
        $query = Event::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        if ($request->has('month') && $request->month != '') {
            $query->whereMonth('event_date', $request->month);
        }

        if ($request->has('year') && $request->year != '') {
            $query->whereYear('event_date', $request->year);
        }

        if ($request->has('venue') && $request->venue != '') {
            $query->where('venue', $request->venue);
        }

        $query->where('status', 'upcoming');
        $query->orderBy('event_date', 'asc');
        $events = $query->paginate(9);

        $venues = Event::select('venue')->distinct()->orderBy('venue')->pluck('venue');
         $today = Carbon::today();
        // Statistik sesuai permintaan
        $stats = [
            'total_eo' => User::where('role', 'admin')
                            ->whereNotNull('name_eo')
                            ->where('name_eo', '!=', '')
                            ->distinct('name_eo')
                            ->count('name_eo'),

             'active_events' => Event::whereDate('event_date', '>', $today)->count(),

        'finished_events' => Event::whereDate('event_date', '<=', $today)->count(),
            'total_admin' => User::where('role', 'admin')->count(),
            'total_superadmin' => User::where('role', 'superadmin')->count(),
        ];

        $chartData = $this->getChartData($request);

        return view('admin.layouts.superadmin_dashboard', compact('events', 'stats', 'venues', 'chartData'));
    }
   
// public function adminDashboard(Request $request)
// {
//     $query = Event::query();

//     if ($request->has('search')) {
//         $query->where('title', 'like', '%' . $request->search . '%');
//     }
//     if ($request->has('type') && $request->type != '') {
//         $query->where('type', $request->type);
//     }
//     if ($request->has('month') && $request->month != '') {
//         $query->whereMonth('event_date', $request->month);
//     }
//     if ($request->has('year') && $request->year != '') {
//         $query->whereYear('event_date', $request->year);
//     }
//     if ($request->has('venue') && $request->venue != '') {
//         $query->where('venue', $request->venue);
//     }

//     $query->where('status', 'upcoming');
//     $query->orderBy('event_date', 'asc');
//     $events = $query->paginate(9);

//     $venues = Event::select('venue')->distinct()->orderBy('venue')->pluck('venue');

//     // 👇 Statistik baru sesuai permintaan
//     $stats = [
//         'total_eo' => User::where('role', 'eo')
//                         ->whereNotNull('nama_eo')
//                         ->where('nama_eo', '!=', '')
//                         ->distinct('nama_eo')
//                         ->count('nama_eo'),

//         'active_events' => Event::where('status', 'aktif')->count(),
//         'finished_events' => Event::where('status', 'selesai')->count(),
//         'total_admin' => User::where('role', 'admin')->count(),
//     ];

//     $chartData = $this->getChartData($request);

//     return view('admin.pages.dashboard.index', compact('events', 'stats', 'venues', 'chartData'));
// }

   public function adminEvents(Request $request)
{
    $query = Event::query();

    // Filter pencarian
    if ($request->has('search') && $request->search != '') {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    if ($request->has('type') && $request->type != '') {
        $query->where('type', $request->type);
    }

    if ($request->has('month') && $request->month != '') {
        $query->whereMonth('event_date', $request->month);
    }

    if ($request->has('year') && $request->year != '') {
        $query->whereYear('event_date', $request->year);
    }

    if ($request->has('venue') && $request->venue != '') {
        $query->where('venue', $request->venue);
    }

    // Hanya ambil event dengan status upcoming
    $query->where('status', 'upcoming')->orderBy('event_date', 'asc');

    // Ambil data event + tiket terjual + checkin
    $events = $query->withCount([
        'ticketOrders as tickets_sold_count' => function ($query) {
            $query->where('status', 'confirmed');
        },
        'checkins as checkin_count'
    ])->paginate(9);

    // Hitung revenue dan belum check-in
    foreach ($events as $event) {
        $event->revenue = $event->tickets_sold_count * $event->price;
        $event->not_checkin_count = $event->tickets_sold_count - $event->checkin_count;
    }

    // Ambil daftar venue unik
    $venues = Event::select('venue')->distinct()->orderBy('venue')->pluck('venue');

    return view('admin.layouts.dashboard', compact('events', 'venues'));
}


    public function show(Event $event)
    {
        $sold = \App\Models\TicketOrder::where('event_id', $event->id)->where('status', 'confirmed')->count();
        $revenue = $sold * $event->price;
        if (auth()->check() && auth()->user()->role === 'superadmin') {
            return view('admin.events.show', compact('event', 'sold', 'revenue'));
        } elseif (auth()->check() && auth()->user()->role === 'admin') {
            return view('admin.events.show', compact('event', 'sold', 'revenue'));
        } else {
            return view('user.layouts.show', compact('event', 'sold'));
        }
    }

    public function create()
    {
       
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        // Pastikan user terautentikasi dan memiliki peran superadmin
       

        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'event_date' => 'required|date|after:today',
            'venue' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Simpan gambar jika ada
       if ($request->hasFile('image')) {
    $image = $request->file('image');
    $filename = time() . '_' . $image->getClientOriginalName(); // contoh: 1716912345_event.jpg
    $image->move(public_path('images'), $filename);
      $validated['image'] = 'images/' . $filename; // Simpan path relatif ke database
            }


        // Tambahkan tiket tersedia
        $validated['available_tickets'] = $validated['capacity'];

        // Simpan event ke database
        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dibuat!');
    }

    public function getChartData(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month');

        // Grafik garis: tiket terjual per hari
        $salesQuery = TicketOrder::where('status', 'confirmed')->whereYear('created_at', $year);
        if ($month) {
            $salesQuery->whereMonth('created_at', $month);
        }
        $salesData = $salesQuery->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Grafik lingkaran: distribusi tiket terjual per tipe event
        $eventTypeData = TicketOrder::where('status', 'confirmed')
            ->with('event')
            ->get()
            ->groupBy(function ($order) {
                return $order->event->type ?? 'Lainnya';
            })
            ->map(function ($group) {
                return $group->count();
            });

        return [
            'sales' => [
                'labels' => $salesData->pluck('date'),
                'data' => $salesData->pluck('total')
            ],
            'eventTypes' => [
                'labels' => $eventTypeData->keys(),
                'data' => $eventTypeData->values()
            ]
        ];
    }

public function orderForm(Event $event)
{
    $jumlahTerjual = \App\Models\TicketOrder::where('event_id', $event->id)->count();

    if ($jumlahTerjual >= $event->capacity) {
        return redirect()->route('events.index')->with('error', 'Tiket untuk event ini sudah habis.');
    }

    $provinces = [
         'Aceh',
    'Sumatera Utara',
    'Sumatera Barat',
    'Riau',
    'Kepulauan Riau',
    'Jambi',
    'Bengkulu',
    'Sumatera Selatan',
    'Kepulauan Bangka Belitung',
    'Lampung',
    'DKI Jakarta',
    'Jawa Barat',
    'Banten',
    'Jawa Tengah',
    'DI Yogyakarta',
    'Jawa Timur',
    'Bali',
    'Nusa Tenggara Barat',
    'Nusa Tenggara Timur',
    'Kalimantan Barat',
    'Kalimantan Tengah',
    'Kalimantan Selatan',
    'Kalimantan Timur',
    'Kalimantan Utara',
    'Sulawesi Utara',
    'Gorontalo',
    'Sulawesi Tengah',
    'Sulawesi Barat',
    'Sulawesi Selatan',
    'Sulawesi Tenggara',
    'Maluku',
    'Maluku Utara',
    'Papua',
    'Papua Barat',
    'Papua Tengah',
    'Papua Pegunungan',
    'Papua Selatan',
    'Papua Barat Daya'
    ];

    $cities = [
    'Aceh' => ['Banda Aceh','Langsa','Lhokseumawe','Sabang','Subulussalam'],
    'Sumatera Utara' => ['Medan','Binjai','Sibolga','Pematangsiantar','Tanjung Balai','Tebing Tinggi','Padang Sidempuan','Gunungsitoli'],
    'Sumatera Barat' => ['Padang','Bukittinggi','Padangpanjang','Pariaman','Payakumbuh','Sawahlunto','Solok'],
    'Riau' => ['Pekanbaru','Dumai'],
    'Kepulauan Riau' => ['Batam','Tanjungpinang'],
    'Jambi' => ['Jambi','Sungai Penuh'],
    'Bengkulu' => ['Bengkulu'],
    'Sumatera Selatan' => ['Palembang','Lubuklinggau','Pagar Alam','Prabumulih'],
    'Kepulauan Bangka Belitung' => ['Pangkalpinang'],
    'Lampung' => ['Bandar Lampung','Metro'],
    'DKI Jakarta' => ['Jakarta Pusat','Jakarta Utara','Jakarta Barat','Jakarta Selatan','Jakarta Timur'],
    'Jawa Barat' => ['Bandung','Bekasi','Bogor','Cimahi','Cirebon','Depok','Sukabumi','Tasikmalaya','Banjar'],
    'Banten' => ['Serang','Cilegon','Tangerang','Tangerang Selatan'],
    'Jawa Tengah' => ['Semarang','Surakarta','Tegal','Pekalongan','Magelang','Salatiga'],
    'DI Yogyakarta' => ['Yogyakarta'],
    'Jawa Timur' => ['Surabaya','Malang','Madiun','Kediri','Blitar','Mojokerto','Pasuruan','Probolinggo','Batu'],
    'Bali' => ['Denpasar'],
    'Nusa Tenggara Barat' => ['Mataram','Bima'],
    'Nusa Tenggara Timur' => ['Kupang'],
    'Kalimantan Barat' => ['Pontianak','Singkawang'],
    'Kalimantan Tengah' => ['Palangkaraya'],
    'Kalimantan Selatan' => ['Banjarmasin','Banjarbaru'],
    'Kalimantan Timur' => ['Samarinda','Balikpapan','Bontang'],
    'Kalimantan Utara' => ['Tarakan'],
    'Sulawesi Utara' => ['Manado','Bitung','Tomohon','Kotamobagu'],
    'Gorontalo' => ['Gorontalo'],
    'Sulawesi Tengah' => ['Palu'],
    'Sulawesi Barat' => [], // Tidak memiliki kota administratif khusus
    'Sulawesi Selatan' => ['Makassar','Parepare','Palopo'],
    'Sulawesi Tenggara' => ['Kendari','Baubau'],
    'Maluku' => ['Ambon','Tual'],
    'Maluku Utara' => ['Ternate','Tidore Kepulauan'],
    'Papua' => ['Jayapura'],
    'Papua Barat' => ['Manokwari','Sorong'],
    'Papua Tengah' => [], // Tidak ada kota administratif utama
    'Papua Pegunungan' => [], // Belum ada kota administratif
    'Papua Selatan' => [], // Belum ada kota administratif
    'Papua Barat Daya' => [], // Belum ada kota administratif
];


    return view('user.layouts.order', compact('event', 'provinces', 'cities'));
}


    public function processOrder(Request $request, Event $event)
    {
         $jumlahTerjual = \App\Models\TicketOrder::where('event_id', $event->id)->count();

        if ($jumlahTerjual >= $event->capacity) {
        return redirect()->route('events.index')->with('error', 'Tiket sudah habis, kapasitas penuh.');
         }

        // Validasi dan simpan data order ke session (atau database jika sudah siap)
        $orderData = $request->only([
            'name',
            'identity_type',
            'identity_number',
            'address',
            'province',
            'city',
            'email',
            'whatsapp'
        ]);
        $request->session()->put('order_' . $event->id, $orderData);
        return redirect()->route('events.payment', $event);
    }

    public function paymentForm(Request $request, Event $event)
    {
        $orderData = $request->session()->get('order_' . $event->id);
        $rekening = [
            'no' => '123456712345',
            'an' => 'Hafiz'
        ];
        return view('user.layouts.payment', compact('event', 'orderData', 'rekening'));
    }

   public function processPayment(Request $request, Event $event)
    {
        
    $request->validate([
        'sender_name' => 'required|string|max:255',
        'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $orderData = $request->session()->get('order_' . $event->id);
    if (!$orderData) {
        return redirect()->route('events.order', $event)->with('error', 'Data order tidak ditemukan.');
    }

    // Buat folder bukti-transfer jika belum ada
    $uploadFolder = public_path('bukti-transfer');
    if (!file_exists($uploadFolder)) {
        mkdir($uploadFolder, 0775, true);
    }

    // Simpan file ke public/bukti-transfer
    $file = $request->file('proof');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $file->move($uploadFolder, $fileName);
    $proofPath = 'bukti-transfer/' . $fileName; // Simpan path relatif

    // Generate kode unik untuk QR
    $kodeUnik = 'TKT-' . uniqid();

    // Simpan data order + qrcode
    $order = \App\Models\TicketOrder::create([
        'event_id' => $event->id,
        'name' => $orderData['name'],
        'identity_type' => $orderData['identity_type'],
        'identity_number' => $orderData['identity_number'],
        'address' => $orderData['address'],
        'province' => $orderData['province'],
        'city' => $orderData['city'],
        'email' => $orderData['email'],
        'whatsapp' => $orderData['whatsapp'],
        'sender_name' => $request->sender_name,
        'proof' => $proofPath,
        'status' => 'pending',
        'qrcode' => $kodeUnik,  // Simpan kode unik QR di sini
    ]);

    // $request->session()->forget('order_' . $event->user);

    // return redirect()->route('user.dashboard')->with('success', 'Order berhasil dikirim! Status: pending, menunggu konfirmasi admin.');
    // return view('user.layouts.payment_page');
    return redirect()->route('order.success',$order->id);
    }


    public function index(Request $request)
    {
        // Contoh ambil semua venue unik dari tabel events
        $venues = \App\Models\Event::select('venue')->distinct()->pluck('venue');

        // Ambil events dengan filter (contoh sederhana)
        $events = \App\Models\Event::query();

        if ($request->filled('venue')) {
            $events->where('venue', $request->venue);
        }
        // ... filter lain

        $events = $events->paginate(10);

        return view('admin.events.index', compact('events', 'venues'));
    }

    public function edit($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'superadmin') {
            abort(403, 'Hanya superadmin yang dapat mengedit event.');
        }
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'superadmin') {
            abort(403, 'Hanya superadmin yang dapat mengedit event.');
        }
        $event = Event::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'event_date' => 'required|date|after:now',
            'venue' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'type' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $validated['image'] = $path;
        }
        $validated['available_tickets'] = $validated['capacity'];
        $event->update($validated);
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diupdate!');
    }

    public function destroy($id)
    {
       
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus!');
    }



    public function downloadQr($orderId)
    {
        $order = \App\Models\TicketOrder::with('event')->findOrFail($orderId);

        $qrData = 'Tiket untuk: ' . $order->name . ' | Event: ' . $order->event->title;

        $qrCode = QrCode::format('png')
            ->size(300)
            ->generate($qrData);

        $fileName = 'qrcodes/ticket_' . $order->id . '.png';
        Storage::disk('public')->put($fileName, $qrCode);

        return response()->download(storage_path('app/public/' . $fileName));
    }
}
