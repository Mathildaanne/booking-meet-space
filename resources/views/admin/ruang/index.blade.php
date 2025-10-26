@extends('layouts.admin')

@section('title', 'Daftar Ruangan')

@section('styles')

<style>
    .card-table {
        width: 100%;
        min-height: 100vh;
        background-color: #fff;
        border: 1px solid #d1d5db;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        overflow-x: auto;
    }

    .card-header {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.25rem;
    }

    @media (min-width: 768px) {
        .card-header {
            flex-direction: row;
            align-items: center;
        }
    }

    .card-header h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add {
        background-color: #3b82f6;
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        min-width: 768px;
    }

    .table th,
    .table td {
        padding: 12px 8px;
        text-align: center;
        vertical-align: middle;
        font-size: 0.875rem;
    }

    .table th {
        background-color: #e0f0ff;
        font-weight: 600;
        color: #1f2937;
    }

    .table img {
        width: 100%;
        max-width: 230px;
        height: 110px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
    }

    .badge-status {
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 9999px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-available {
        background-color: #d1fae5;
        color: #065f46;
    }

    .badge-unavailable {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .btn-action {
        padding: 5px 12px;
        font-size: 0.75rem;
        border-radius: 6px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        margin: 0 2px;
        white-space: nowrap;
    }

    .btn-info {
        background-color: #e0f2fe;
        color: #0284c7;
    }

    .btn-warning {
        background-color: #fef9c3;
        color: #b45309;
    }

    .btn-danger {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    /* Responsive Table on Small Screens */
    @media (max-width: 768px) {
        .table thead {
            display: none;
        }

        .table, .table tbody, .table tr, .table td {
            display: block;
            width: 100%;
        }

        .table tr {
            margin-bottom: 1.2rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .table td {
            text-align: left;
            padding-left: 50%;
            position: relative;
        }

        .table td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            top: 12px;
            font-weight: 600;
            color: #4b5563;
            font-size: 0.85rem;
        }

        .table img {
            max-width: 100%;
            height: auto;
        }
    }
</style>
@endsection

@section('content')
<div class="card-table">
    <div class="card-header">
        <h3><i class="fas fa-building text-blue-600"></i> Daftar Ruangan</h3>
        <a href="{{ route('admin.ruang.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Tambah Ruangan
        </a>
    </div>

    <div class="table-responsive border border-blue-500 rounded-lg shadow overflow-hidden">
        <table id="tabel-ruangan" class="table table-bordered min-w-full w-full shadow-sm rounded-lg overflow-hidden divide-y divide-blue-500">
            <thead class="bg-blue-200 text-left">
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Kapasitas</th>
                    <th>Jam Operasional</th>
                    <th>Lantai</th>
                    <th>Fasilitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black-100">
                @forelse ($ruang as $item)
                <tr>
                    <td>
                        <img src="{{ $item->foto ? Storage::url($item->foto) : 'https://via.placeholder.com/100x70?text=No+Image' }}"
                            alt="Foto Ruangan"
                            class="image-thumb">
                    </td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kapasitas }} orang</td>
                    <td>{{ $item->jam_buka }} - {{ $item->jam_tutup }}</td>
                    <td>{{ $item->lantai ?? '-' }}</td>
                    <td>{{ $item->fasilitas ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.ruang.show', $item) }}" class="btn-action btn-info">Detail</a>
                        <a href="{{ route('admin.ruang.edit', $item) }}" class="btn-action btn-warning">Edit</a>
                        <form action="{{ route('admin.ruang.destroy', $item) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus ruangan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-3">Belum ada ruangan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

