@extends('layouts.user')

@section('title', 'Jadwal ' . $ruang->nama)

@section('content')
<div class="px-6 lg:px-10 py-6">
    <h2 class="text-2xl font-bold mb-4">Jadwal Booking: {{ $ruang->nama }}</h2>

    @if($bookings->isEmpty())
        <p class="text-gray-600 italic">Belum ada booking untuk ruangan ini.</p>
    @else
    <table class="table-auto w-full text-sm border shadow rounded">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-3 py-2 border">Tanggal</th>
                <th class="px-3 py-2 border">Jam Mulai</th>
                <th class="px-3 py-2 border">Jam Selesai</th>
                <th class="px-3 py-2 border">Nama</th>
                <th class="px-3 py-2 border">Keperluan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td class="px-3 py-1 border">
                    {{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('l, d F Y') }}
                </td>
                <td class="px-3 py-1 border">{{ $booking->jam_mulai }}</td>
                <td class="px-3 py-1 border">{{ $booking->jam_selesai }}</td>
                <td class="px-3 py-1 border">{{ $booking->nama }}</td>
                <td class="px-3 py-1 border">{{ $booking->keperluan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="mt-6">
        <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:underline text-sm">
            ← Kembali ke daftar ruangan
        </a>
    </div>
</div>
@endsection
