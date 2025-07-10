@extends('layouts.admin')

@section('title', 'Daftar Ruangan')

@section('content')
<a href="{{ route('admin.ruang.create') }}" class="btn btn-primary mb-3">+ Tambah Ruangan</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Foto</th>
            <th>Kapasitas</th>
            <th>Jam</th>
            <th>Lantai</th>
            <th>Fasilitas</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ruang as $ruang)
        <tr>
            <td>{{ $ruang->nama }}</td>
            <td>{{ $ruang->foto }}</td>
            <td>{{ $ruang->kapasitas }}</td>
            <td>{{ $ruang->jam_buka }} - {{ $ruang->jam_tutup }}</td>
            <td>{{ $ruang->lantai ?? '-' }}</td>
            <td>{{ $ruang->fasilitas ?? '-' }}</td>
            <td>
                <a href="{{ route('admin.ruang.show', $ruang) }}" class="btn btn-sm btn-info">Detail</a>
                <a href="{{ route('admin.ruang.edit', $ruang) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.ruang.destroy', $ruang) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus ruangan ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
