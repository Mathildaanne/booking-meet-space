@extends('layouts.admin')
@section('title', 'Detail Booking')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .detail-card {
        background-color: #fff;
        border: 1px solid #cbd5e0;
        border-radius: 12px;
        padding: 2rem;
        max-width: 700px;
        margin: 2rem auto;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .detail-header {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .detail-list {
        list-style: none;
        padding-left: 0;
    }

    .detail-list li {
        margin-bottom: 12px;
        font-size: 1rem;
        color: #374151;
    }

    .detail-list strong {
        color: #1f2937;
        display: inline-block;
        width: 120px;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-approved {
        background-color: #d1fae5;
        color: #059669;
    }

    .status-pending {
        background-color: #fef9c3;
        color: #b45309;
    }

    .status-rejected {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .back-btn {
        margin-top: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="detail-card">
    <div class="detail-header">
        <i class="fas fa-calendar-check text-blue-600"></i> Detail Booking
    </div>

    <ul class="detail-list">
        <li><strong>Ruangan:</strong> {{ optional($booking->ruang)->nama ?? '-' }}</li>
        <li><strong>Peminjam:</strong> {{ optional($booking->user)->nama ?? '-' }}</li>
        <li><strong>Tanggal:</strong> {{ $booking->tanggal_booking }}</li>
        <li><strong>Jam:</strong> {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</li>
        <li><strong>Jumlah Orang:</strong> {{ $booking->jumlah_orang }}</li>
        <li><strong>Keperluan:</strong> {{ $booking->keperluan }}</li>

    </ul>

    <div class="back-btn">
        <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>
@endsection
