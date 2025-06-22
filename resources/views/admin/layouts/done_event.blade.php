@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <h4>Done Events</h4>
        <div class="card shadow mb-4 rounded-3">
            <div class="card-header py-3 bg-primary text-white rounded-top">
                <h6 class="m-0 font-weight-bold">Daftar Event</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($events as $event)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm border-0 rounded-4">
                                <img src="{{ asset($event->image) }}" class="card-img-top rounded-top" alt="{{ $event->title }}"
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $event->title }}</h5>
                                    <p class="card-text mb-2 text-muted">
                                        <i class="fas fa-dollar-sign text-success"></i>
                                        Rp {{ number_format($event->price, 0, ',', '.') }} / tiket
                                    </p>
                                    <p class="card-text mb-1">
                                        <i class="fas fa-money-bill-wave text-primary"></i>
                                        Total Pendapatan: <strong>Rp {{ number_format($event->revenue, 0, ',', '.') }}</strong>
                                    </p>
                                    <p class="card-text mb-1">
                                        <i class="fas fa-shopping-cart text-info"></i>
                                        Tiket Terjual: <strong>{{ $event->tickets_sold_count }}</strong> dari
                                        {{ $event->capacity }}
                                    </p>
                                    <p class="card-text mb-1">
                                        <i class="fas fa-sign-in-alt text-success"></i>
                                        Sudah Check-in: <strong>{{ $event->checkin_count }}</strong>
                                    </p>
                                    <p class="card-text mb-3">
                                        <i class="fas fa-user-clock text-warning"></i>
                                        Belum Check-in: <strong>{{ $event->not_checkin_count }}</strong>
                                    </p>

                                    <a href="{{ route('events.show', $event) }}" class="btn btn-outline-info w-100">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                Tidak ada event tersedia.
                            </div>
                        </div>
                    @endforelse
                </div>
@endsection