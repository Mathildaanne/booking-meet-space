@extends('layouts.admin')

@section('title', 'Edit Ruangan')

@section('content')
<form method="POST" action="{{ route('admin.ruang.update', $ruang->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" value="{{ old('nama', $ruang->nama ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label>Kapasitas</label>
        <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas', $ruang->kapasitas ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label>Jam Buka</label>
        <input type="time" name="jam_buka" class="form-control" value="{{ old('jam_buka', $ruang->jam_buka ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label>Jam Tutup</label>
        <input type="time" name="jam_tutup" class="form-control" value="{{ old('jam_tutup', $ruang->jam_tutup ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label>Lantai</label>
        <input type="number" name="lantai" class="form-control" value="{{ old('lantai', $ruang->lantai ?? '') }}">
    </div>

    <div class="mb-3">
        <label>Fasilitas</label>
        <textarea name="fasilitas" class="form-control">{{ old('fasilitas', $ruang->fasilitas ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Foto</label>
        <input type="file" name="foto" class="form-control">
        @if(isset($ruang) && $ruang->foto)
            <img src="{{ asset('storage/' . $ruang->foto) }}" width="100" class="mt-2">
        @endif

    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('admin.ruang.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
