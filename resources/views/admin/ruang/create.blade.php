@extends('layouts.admin')

@section('title', 'Tambah Ruangan')

@section('content')
<form method="POST" action="{{ route('admin.ruang.store') }}" enctype="multipart/form-data">
    @csrf
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
    </div>

    <div class="mb-3">
        <label>Kapasitas</label>
        <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas') }}" required>
    </div>

    <div class="mb-3">
        <label>Jam Buka</label>
        <input type="time" name="jam_buka" class="form-control" value="{{ old('jam_buka') }}" required>
    </div>

    <div class="mb-3">
        <label>Jam Tutup</label>
        <input type="time" name="jam_tutup" class="form-control" value="{{ old('jam_tutup') }}" required>
    </div>

    <div class="mb-3">
        <label>Lantai</label>
        <input type="number" name="lantai" class="form-control" value="{{ old('lantai') }}">
    </div>

    <div class="mb-3">
        <label>Fasilitas</label>
        <textarea name="fasilitas" class="form-control">{{ old('fasilitas') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Foto (opsional)</label>
        <input type="file" name="foto" class="form-control">
        @if(isset($ruang) && $ruang->foto)
            <img src="{{ asset('storage/' . $ruang->foto) }}" width="100" class="mt-2">
        @endif
    </div>
    
    <button class="btn btn-primary">Simpan</button>
</form>
@endsection
