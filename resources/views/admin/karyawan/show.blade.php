@extends('layouts.admin')

@section('title', 'Admin - Detail Karyawan')

@section('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Booking CSS -->
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .card-glass {
        background: rgba(255, 255, 255, 0.06);
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
        color: white;
        margin: 40px auto;
        max-width: 600px;
        text-align: center;
    }

    .card-glass h1 {
        margin-bottom: 20px;
    }

    .card-glass img {
        margin-bottom: 20px;
        text-align: center;
    }

    .btn-glass {
        background-color: rgba(255,255,255,0.2);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        transition: background-color 0.3s;
    }

    .btn-glass:hover {
        background-color: rgba(255,255,255,0.4);
    }
</style>

<div class="card-glass">
    <h1>Detail Karyawan</h1>

    <p><strong>Nama :</strong>{{ $karyawan->nama }}</p>
    <p><strong>Jabatan :</strong> {{ $karyawan->jabatan }}</p>
    <p><strong>Email :</strong> {{ $karyawan->email }}</p>
    <p><strong>Role :</strong> {{ $karyawan->role }}</p>

    <div class="mt-3">
        <a href="{{ route('admin.karyawan.index') }}" class="btn-glass">Kembali</a>
    </div>
</div>
@endsection
