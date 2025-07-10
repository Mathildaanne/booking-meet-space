@extends('layouts.admin')
@section('title', 'Detail Booking')

@section('content')
<h3>Detail Booking</h3>

<ul>
    <li><strong>Ruangan:</strong> {{ $booking->ruang->nama }}</li>
    <li><strong>Peminjam:</strong> {{ $booking->user->nama }}</li>
    <li><strong>Tanggal:</strong> {{ $booking->tanggal_booking }}</li>
    <li><strong>Jam:</strong> {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</li>
    <li><strong>Status:</strong> {{ ucfirst($booking->status) }}</li>
</ul>

<a href="{{ route('bookings.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
