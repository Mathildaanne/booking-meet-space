@extends('layouts.admin')

@section('title', 'Dashboard Admin')

<head>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .summary-section {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .summary-card {
            flex: 1 1 30%;
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.06);
            border: 1px solid #e5e7eb;
            transition: 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-4px);
            border-color: #3b82f6;
        }

        .summary-icon {
            font-size: 28px;
            margin-bottom: 8px;
            display: inline-block;
            color: #3b82f6;
        }

        .summary-title {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #111827;
        }
        .card-custom {
            border-radius: 16px;
            border: 2px solid #0A2084;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .schedule-item {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);

            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .section-title-large {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .schedule-item:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }
        .schedule-info {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .btn-detail {
            font-size: 14px;
            padding: 4px 12px;
            border-radius: 6px;
            border-color: #0A2084;
            color: #0A2084;
        }
        .btn-detail:hover {
            background-color: #0A2084;
            color: #fff;
            border-color: #0A2084;
        }
        .text-primary {
            color: #0A2084 !important;
        }
        .btn-outline-primary {
            border-color: #0A2084;
            color: #0A2084;
        }
        .btn-outline-primary:hover {
            background-color: #0A2084;
            color: #fff;
        }

        /* WARNA TEMA DASHBOARD */
        .bg-users {
            background-color: #A4CCD9;
        }
        .bg-booking {
            background-color: #A4CCD9;
        }
        .bg-ruangan {
            background-color: #A4CCD9;
        }

        @media (max-width: 480px) {
            .stat-box {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>

@section('content')
<!-- Hero Header -->
<div class="mb-4 relative text-white rounded overflow-hidden shadow-lg" style="min-height: 150px;">
    <img src="{{ asset('images/admin.png') }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover brightness-75">
    <div class="relative z-10 p-6">
        <h3 class="text-2xl fw-bold drop-shadow-lg">Hello Admin! 👋</h3>
        <p class="text-sm drop-shadow-sm">Selamat Datang di Meet Space</p>
    </div>
</div>

<!-- Statistik Ringkas -->
<div class="px-6 lg:px-10">
    <div class="summary-section mb-4">
        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-people-fill"></i></div>
            <div class="summary-title">Total User</div>
            <div class="summary-value">{{ $totalUsers ?? 0 }}</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-calendar-event-fill"></i></div>
            <div class="summary-title">Total Booking</div>
            <div class="summary-value">{{ $totalBooking ?? 0 }}</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon cancel-icon"><i class="bi bi-door-open-fill"></i></div>
            <div class="summary-title">Total Ruangan</div>
            <div class="summary-value cancel-icon">{{ $totalRuangan ?? 0 }}</div>
        </div>
    </div>

    <!-- Jadwal Hari Ini -->
    <div class="card-custom mb-4">
        <h1 class="text-center text-primary section-title-large mb-3">Jadwal Hari Ini</h1>

        @if(count($todaySchedules ?? []) > 0)
            @foreach($todaySchedules as $schedule)
                <div class="schedule-item">
                    <div class="schedule-info">
                        <i class="bi bi-calendar-check text-primary fs-5"></i>
                        <div>
                            <div class="fw-bold text-primary">{{ $schedule->user->nama }}</div>
                            <div>{{ $schedule->ruang->nama }} | {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H.i') }} - {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H.i') }}</div>
                        </div>
                    </div>
                    <div class="border rounded p-2">
                        <a href="{{ route('admin.booking.detail', $schedule->id) }}" class="btn btn-outline-primary btn-sm btn-detail">Detail</a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center text-muted">Tidak ada jadwal hari ini</div>
        @endif
    </div>
</div>
@endsection
