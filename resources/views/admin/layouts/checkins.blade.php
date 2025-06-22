@extends('admin.layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Check-ins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Daftar Checkins</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nomor Identitas</th>
                <th>Judul Event</th>
                <th>Jam Check-in</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checkins as $index => $checkin)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $checkin->name }}</td>
                    <td>{{ $checkin->identity_number }}</td>
                    <td>{{ $checkin->event->title ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($checkin->jam_checkin)->format('H:i:s') }}</td>
                    <td>
                        <span class="badge bg-{{ $checkin->status == 'valid' ? 'success' : 'danger' }}">
                            {{ ucfirst($checkin->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
@endsection