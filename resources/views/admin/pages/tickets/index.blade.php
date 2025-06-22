@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Daftar Pembelian Tiket</h1>

    {{-- Notifikasi Sukses --}}
    @if(session('sheet_url'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil diekspor ke Google Sheets.
            <a href="{{ session('sheet_url') }}" class="btn btn-sm btn-success ms-2" target="_blank">
                <i class="fas fa-external-link-alt"></i> Lihat Google Sheets
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Notifikasi Error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
        <a href="{{ route('tickets.export-sheet') }}" class="btn btn-primary mb-3">
            <i class="fas fa-file-export"></i> Export ke Google Sheets
        </a>
    @endif

    <div class="card shadow mb-4 rounded-4 border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Event</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No WhatsApp</th>
                            <th>Status</th>
                            <th>Bukti Transfer</th>
                            <th>Kode QR</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $order->event->title ?? '-' }}</strong></td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->whatsapp }}</td>
                                <td>
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning text-dark px-3 py-2">
                                            <i class="fas fa-hourglass-half me-1"></i> Pending
                                        </span>
                                    @else
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i> Confirmed
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->proof)
                                        <a href="{{ asset($order->proof) }}" target="_blank"
                                           class="btn btn-outline-primary btn-sm px-2 py-1">
                                            <i class="fas fa-image me-1"></i> Lihat Bukti
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $order->qrcode }}</td>
                                <td>
                                    <a href="{{ route('admin.tickets.show', $order->id) }}"
                                       class="btn btn-info btn-sm px-2 py-1 mb-1">
                                        <i class="fas fa-eye"></i> View
                                    </a>

                                    <form action="{{ route('admin.tickets.destroy', $order->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>

                                    @if($order->status == 'pending')
                                        <form action="{{ route('admin.tickets.update', $order->id) }}" method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm px-2 py-1 mb-1"
                                                    onclick="return confirm('Konfirmasi order ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Belum ada pembelian tiket.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
