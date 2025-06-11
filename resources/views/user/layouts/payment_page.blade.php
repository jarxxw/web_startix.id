@extends('user.layouts.header')

@section('content')
<div class="container text-center mt-5">
    <!-- Ikon sukses -->
    <div class="mb-4">
        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
    </div>

    <!-- Pesan sukses -->
    <h1 class="mb-3">Pembayaran Anda Berhasil</h1>
    <h4 class="mb-4">Terima kasih, <strong>{{ $order->name }}</strong>!</h4>
    <p class="mb-5"><strong>E-ticket akan dikirim ke email setelah periode berakhir.</strong><br>Mohon cek email secara berkala.</p>

    <!-- Tombol kembali -->
    <form action="{{ route('user.dashboard') }}">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </button>
    </form>

    <!-- Logo metode pembayaran -->
    {{-- <div class="mt-5">
        <div class="d-flex justify-content-center gap-4">
            <img src="{{ asset('images/bni.png') }}" alt="BNI" height="40">
            <img src="{{ asset('images/bri.png') }}" alt="BRI" height="40">
            <img src="{{ asset('images/dana.png') }}" alt="DANA" height="40">
            <img src="{{ asset('images/shopeepay.png') }}" alt="ShopeePay" height="40">
        </div>
    </div> --}}
</div>
@endsection
