@extends('layouts.admin')

@section('title', 'Admin - Edit Karyawan')

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
        margin: 20px auto; 
        max-width: 600px; 
    } 
</style> 

<div class="card-glass text-gray-800"> 
    <h2 class="mb-4">Edit Karyawan</h2> 
    <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3"> 
            <label for="nama" class="form-label">Nama :</label> 
            <input type="text" name="nama" id="nama" class="form-control bg-white text-dark" value="{{ $karyawan->nama }}" required>
            @error('nama') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3"> 
            <label for="jabatan" class="form-label">Jabatan :</label> 
            <input type="text" name="jabatan" id="jabatan" class="form-control bg-white text-dark" value="{{ $karyawan->jabatan }}" required>
            @error('jabatan') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3"> 
            <label for="email" class="form-label">Email :</label> 
            <input type="text" name="email" id="jabatan" class="form-control bg-white text-dark" value="{{ $karyawan->email }}" required>
            @error('email') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div> 
@endsection
