@extends('layouts.user')

@section('title', 'Detail Booking')

@section('content')
<div class="container mt-4">
    <h3>Detail Booking</h3>

    <div class="card mt-3">
        <div class="card-body">
            <p><strong>Ruangan:</strong> {{ $booking->ruang->nama }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('l, d F Y') }}</p>
            <p><strong>Waktu:</strong> {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</p>
            <p><strong>Status:</strong> <span class="badge bg-success">{{ ucfirst($booking->status) }}</span></p>
            <a href="{{ route('user.jadwal.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
