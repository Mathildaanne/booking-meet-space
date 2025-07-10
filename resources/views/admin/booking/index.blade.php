@extends('layouts.admin')
@section('title', 'Data Booking')

@section('content')
<h3>Data Booking</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Ruangan</th>
            <th>Peminjam</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bookings as $booking)
        <tr>
            <td>{{ $booking->ruang->nama }}</td>
            <td>{{ $booking->user->nama }}</td>
            <td>{{ $booking->tanggal_booking }}</td>
            <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
            <td>
                <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'danger') }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </td>
            <td>
                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info">Detail</a>
                <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}" style="display:inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus booking ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
