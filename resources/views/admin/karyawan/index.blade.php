@extends('layouts.admin')

@section('title', 'Admin - Karyawan')

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .status-badge {
            padding: 4px 10px;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
        }

        .status-active {
            background-color: #d1fae5;
            color: #059669;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .table-action a {
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0 0.3rem;
        }

        .table-action a:hover {
            text-decoration: underline;
        }

        .table-action .detail {
            color: #2563eb; /* blue-600 */
        }

        .table-action .edit {
            color: #ca8a04; /* yellow-600 */
        }

        .table-action .hapus {
            color: #dc2626; /* red-600 */
        }
    </style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-4">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-users text-blue-600"></i>
            Daftar Karyawan
        </h2>
    </div>

    @if (session('success'))
        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg border border-green-200 mb-4 flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-3">
        <select name="status_filter" id="status_filter"
                class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
            <option value="">Status</option>
            <option value="active">Active</option>
            <option value="inactive">Not Active</option>
        </select>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 font-semibold">Nama</th>
                    <th class="px-6 py-3 font-semibold">Email</th>
                    <th class="px-6 py-3 font-semibold">Jabatan</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($karyawans as $karyawan)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $karyawan->nama }}</td>
                        <td class="px-6 py-4">{{ $karyawan->email }}</td>
                        <td class="px-6 py-4">{{ $karyawan->jabatan }}</td>
                        <td class="px-6 py-4">
                            @if ($karyawan->status === 'active')
                                <span class="status-badge status-active">Active</span>
                            @else
                                <span class="status-badge status-inactive">Not Active</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 table-action">
                            <a href="{{ route('admin.karyawan.detail', $karyawan->id) }}" class="detail">Detail</a>
                            <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="edit">Edit</a>
                            <form action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="hapus bg-transparent border-0 p-0 m-0">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-5 italic">Belum ada data karyawan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
