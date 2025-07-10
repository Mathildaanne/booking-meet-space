@extends('layouts.user')

@section('title', 'Jadwal Saya')

@section('content')
<div class="container mt-4">
    <h3>Jadwal Booking Saya</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Ruangan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
            <tr>
                <td>{{ $booking->ruang->nama }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</td>
                <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                <td><span class="badge bg-info text-dark">{{ ucfirst($booking->status) }}</span></td>
                <td>
                    <a href="{{ route('user.jadwal.show', $booking->id) }}" class="btn btn-sm btn-primary">Detail</a>
                    <form action="{{ route('user.jadwal.destroy', $booking->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin batalkan booking ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Batal</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada booking.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
