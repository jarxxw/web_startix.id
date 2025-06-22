@extends('admin.layouts.app')

@section('content')
<div class="container">
    <!-- Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Event</h1>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4 rounded-3">
        <div class="card-header py-3 bg-primary text-white rounded-top">
            <h6 class="m-0 font-weight-bold">Filter Events</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.acara') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="search" placeholder="Cari event..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="type">
                        <option value="">Semua Tipe</option>
                        <option value="conference" {{ request('type') == 'conference' ? 'selected' : '' }}>Conference</option>
                        <option value="workshop" {{ request('type') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                        <option value="seminar" {{ request('type') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="month">
                        <option value="">Semua Bulan</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="year">
                        <option value="">Semua Tahun</option>
                        @foreach(range(date('Y'), date('Y') + 2) as $y)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="venue">
                        <option value="">Semua Venue</option>
                        @foreach($venues as $venue)
                            <option value="{{ $venue }}" {{ request('venue') == $venue ? 'selected' : '' }}>{{ $venue }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>

                <!-- Buttons: Daftar Event & Tambah Event -->
                <div class="col-md-12 text-end mt-2">
                    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-list"></i> Daftar Event
                    </a>
                    <a href="{{ route('admin.events.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Event
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Event List -->
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
                                    Tiket Terjual: <strong>{{ $event->tickets_sold_count }}</strong> dari {{ $event->capacity }}
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
                        <div class="alert alert-info">Tidak ada event yang ditemukan.</div>
                    </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
