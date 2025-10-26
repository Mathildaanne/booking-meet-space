@extends('layouts.user')

@section('title', 'Detail Booking')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .detail-wrapper {
        max-width: 960px;
        margin: 40px auto;
        background: #fff;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        animation: fadeInUp 0.5s ease-in-out;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .section-title {
        text-align: center;
        font-weight: 700;
        font-size: 1.9rem;
        margin-bottom: 2rem;
        color: #333;
    }

    .info-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .info-value {
        margin-bottom: 1rem;
        color: #111827;
    }

    .badge-status {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .badge-active {
        background-color: #fef9c3;
        color: #ca8a04;
    }

    .badge-finished {
        background-color: #d1fae5;
        color: #059669;
    }

    .badge-cancelled {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .btn-glass {
        background-color: #f3f4f6;
        border: none;
        color: #1f2937;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-glass:hover {
        background-color: #e5e7eb;
    }
</style>
@endsection

@section('content')
<div class="detail-wrapper">
    <div class="section-title">
        <i class="fas fa-calendar-alt me-2 text-primary"></i> Detail Booking
    </div>

    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div>
                <div class="info-label">Ruangan</div>
                <div class="info-value">{{ $booking->ruang->nama }}</div>
            </div>
            <div>
                <div class="info-label">Tanggal Booking</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('l, d F Y') }}</div>
            </div>
            <div>
                <div class="info-label">Waktu</div>
                <div class="info-value">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            @if ($booking->keperluan)
            <div>
                <div class="info-label">Keperluan</div>
                <div class="info-value">{{ $booking->keperluan }}</div>
            </div>
            @endif
            <div>
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span class="badge-status badge-{{ strtolower($booking->status) }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mt-4">
        <a href="{{ route('user.jadwal.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>
@endsection
