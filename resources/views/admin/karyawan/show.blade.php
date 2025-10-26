@extends('layouts.admin')

@section('title', 'Admin - Detail Karyawan')

@section('styles')
<!-- Font Awesome -->
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

    .avatar-detail {
        width: 150px;
        height: 150px;
        border-radius: 50%;
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

    .badge-status {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-active {
        background-color: #d1fae5;
        color: #059669;
    }

    .badge-inactive {
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
        <i class="fas fa-user me-2 text-primary"></i> Detail Karyawan
    </div>

    <div class="row g-4 align-items-center">
        <!-- Foto -->
        <div class="col-12 col-md-4 text-center">
            @if ($karyawan->foto)
                <img src="{{ asset('storage/foto/' . $karyawan->foto) }}" class="avatar-detail" alt="Foto Karyawan">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($karyawan->nama) }}&background=random"
                     class="avatar-detail" alt="Default Avatar">
            @endif
        </div>

        <!-- Data -->
        <div class="col-12 col-md-8">
            <div>
                <div class="info-label">Nama Lengkap</div>
                <div class="info-value">{{ $karyawan->nama }}</div>
            </div>
            <div>
                <div class="info-label">Jabatan</div>
                <div class="info-value">{{ $karyawan->jabatan }}</div>
            </div>
            <div>
                <div class="info-label">Email</div>
                <div class="info-value">{{ $karyawan->email }}</div>
            </div>
            <div>
                <div class="info-label">Role</div>
                <div class="info-value text-capitalize">{{ $karyawan->role }}</div>
            </div>
            <div>
                <div class="info-label">Status</div>
                <div class="info-value">
                    @if ($karyawan->status === 'active')
                        <span class="badge-status badge-active">Active</span>
                    @else
                        <span class="badge-status badge-inactive">Not Active</span>
                    @endif
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
