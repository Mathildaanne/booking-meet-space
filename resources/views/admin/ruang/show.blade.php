@extends('layouts.admin')

@section('title', 'Admin - Detail Ruangan')

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
        to   { opacity: 1; transform: translateY(0); }
    }

    .section-title {
        text-align: center;
        font-weight: 700;
        font-size: 1.9rem;
        margin-bottom: 2rem;
        color: #333;
    }

    .avatar-detail {
        width: 100%;
        max-width: 250px;
        height: auto;
        border-radius: 15px;
        object-fit: cover;
        border: 4px solid #edf2f7;
        box-shadow: 0 4px 15px rgba(0, 0, 0, .1);
        margin-bottom: 1rem;
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
        <i class="fas fa-door-open me-2 text-primary"></i> Detail Ruangan
    </div>

    <div class="row g-4 align-items-center">
        <!-- Foto -->
        <div class="col-12 col-md-4 text-center">
            @if ($ruang->foto)
                <img src="{{ asset('storage/' . $ruang->foto) }}" class="avatar-detail" alt="Foto Ruangan">
            @else
                <img src="https://via.placeholder.com/250x180?text=Foto+Ruangan" class="avatar-detail" alt="Default">
            @endif
        </div>

        <!-- Data -->
        <div class="col-12 col-md-8">
            <div>
                <div class="info-label">Nama Ruangan</div>
                <div class="info-value">{{ $ruang->nama }}</div>
            </div>
            <div>
                <div class="info-label">Kapasitas</div>
                <div class="info-value">{{ $ruang->kapasitas }} orang</div>
            </div>
            <div>
                <div class="info-label">Jam Operasional</div>
                <div class="info-value">
                    {{ \Carbon\Carbon::parse($ruang->jam_buka)->format('H:i') }} - 
                    {{ \Carbon\Carbon::parse($ruang->jam_tutup)->format('H:i') }}
                </div>
            </div>
            <div>
                <div class="info-label">Lantai</div>
                <div class="info-value">{{ $ruang->lantai ?? '-' }}</div>
            </div>
            <div>
                <div class="info-label">Fasilitas</div>
                <div class="info-value">{!! nl2br(e($ruang->fasilitas)) ?: '-' !!}</div>
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('admin.ruang.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
