@extends('layouts.admin')

@section('title', 'Detail Ruangan')

@section('content')
<div class="card">
    <div class="card-header">
        <strong>{{ $ruang->nama }}</strong>
    </div>
    <div class="card-body">
        <p><strong>Kapasitas:</strong> {{ $ruang->kapasitas }}</p>
        <p><strong>Jam Operasional:</strong> {{ $ruang->jam_buka }} - {{ $ruang->jam_tutup }}</p>
        <p><strong>Lantai:</strong> {{ $ruang->lantai ?? '-' }}</p>
        <p><strong>Fasilitas:</strong><br> {!! nl2br(e($ruang->fasilitas)) !!}</p>

        @if($ruang->foto)
            <p><strong>Foto:</strong><br>
            <img src="{{ asset('storage/' . $ruang->foto) }}" width="300">
            </p>
        @endif

        <a href="{{ route('admin.ruang.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
</div>
@endsection
