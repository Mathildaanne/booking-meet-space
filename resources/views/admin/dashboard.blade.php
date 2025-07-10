@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<!-- Header -->
<div 
    class="mb-4 shadow text-white -mx-6 mx-10 px-6 rounded"
    style="background-image: url('{{ asset('images/admin.png') }}'); min-height: 150px; background-size: cover; background-position: center;"
>
    <div class="relative z-10 p-4">
        <h3 class="text-2xl fw-bold">Hello Admin! 👋</h3>
        <p class="text-sm">Selamat Datang di Meet Space</p>
    </div>
</div>

<!-- Statistik Atas -->
<div class="row text-center mb-4">
    <div class="col-md-3 mb-2">
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="mb-1 text-muted">Total Users</p>
                <h4 class="fw-bold text-primary">#</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-2">
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="mb-1 text-muted">Total Booking</p>
                <h4 class="fw-bold text-success">{{ $todayBooking }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-2">
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="mb-1 text-muted">Baru Booking</p>
                <h4 class="fw-bold text-warning">#</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-2">
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="mb-1 text-muted">Total Ruangan</p>
                <h4 class="fw-bold text-danger">{{ $totalRuangan }}</h4>
            </div>
        </div>
    </div>
</div>

<!-- Jadwal Hari Ini -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="text-center fw-bold mb-3">Jadwal Hari Ini</h5>

        <div class="d-flex align-items-center justify-content-between border rounded px-3 py-2 mb-2 shadow-sm bg-white">
            <div class="d-flex align-items-center">
                <i class="bi bi-calendar-check text-primary me-3 fs-4"></i>
                <div>
                    <div class="fw-semibold"></div>
                    <div class="text-muted small"><div>
                </div>
            </div>
            <a href="" class="btn btn-outline-primary btn-sm">Detail</a>
        </div>
        <div class="text-center text-muted">Tidak ada jadwal hari ini</div>
    </div>
</div>

<!-- Chart -->
<div class="card mt-4 p-4 shadow">
    <h5 class="mb-3">Statistik Booking Tahunan</h5>
    <canvas id="adminBookingChart" height="100"></canvas>
</div>

<script>
    const ctx = document.getElementById('adminBookingChart').getContext('2d');
    const adminBookingChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Total Booking',
                data: @json($chartData),
                backgroundColor: 'rgba(16, 185, 129, 0.5)',
                borderColor: 'rgba(5, 150, 105, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>

@endsection