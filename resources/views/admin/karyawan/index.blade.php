@extends('layouts.admin')

@section('title', 'Admin - Karyawan')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<style>
    .status-badge {
        padding: 4px 12px;
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
    .action-btn {
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
    }
    .action-btn.detail {
        background-color: #e0f2fe;
        color: #0284c7;
    }
    .action-btn.edit {
        background-color: #fef9c3;
        color: #b45309;
    }
    .action-btn.delete {
        background-color: #fee2e2;
        color: #b91c1c;
    }
    .avatar-thumb {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }
    img.rounded-full {
        border: 2px solid #e5e7eb;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .left-buttons {
    display: flex;
    gap: 8px;
}

</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-4">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-users text-blue-600"></i> Daftar Karyawan
        </h2>
        <a href="{{ route('admin.karyawan.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow">
            <i class="fa fa-plus mr-2"></i> Tambah Karyawan
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg border border-green-200 mb-4 flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-blue-500 rounded-lg shadow overflow-hidden">
        <form method="GET" action="{{ route('admin.karyawan.index') }}">
            <div class="p-4 flex justify-between items-center flex-wrap gap-2">
                <div>
                    <label for="status_filter" class="block text-sm font-medium text-gray-700 text-right">Filter Status</label>
                    <select id="status_filter" name="status" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Not Active</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto p-4">
            <table id="karyawan-table" class="min-w-full divide-y divide-blue-500 text-sm">
                <thead class="bg-blue-200 text-left">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Foto</th>
                        <th class="px-6 py-3 font-semibold">Nama</th>
                        <th class="px-6 py-3 font-semibold">Email</th>
                        <th class="px-6 py-3 font-semibold">Jabatan</th>
                        <th class="px-6 py-3 font-semibold">Role</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black-100">
                    @forelse ($karyawans as $karyawan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <img src="{{ $karyawan->foto ? asset('storage/foto/' . $karyawan->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($karyawan->nama) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover">
                            </td>
                            <td class="px-6 py-4">{{ $karyawan->nama }}</td>
                            <td class="px-6 py-4">{{ $karyawan->email }}</td>
                            <td class="px-6 py-4">{{ $karyawan->jabatan }}</td>
                            <td class="px-6 py-4">{{ ucfirst($karyawan->role) }}</td>
                            <td class="px-6 py-4">
                                <span class="status-badge {{ $karyawan->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                    {{ $karyawan->status === 'active' ? 'Active' : 'Not Active' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 space-x-1 whitespace-nowrap">
                                <a href="{{ route('admin.karyawan.detail', $karyawan->id) }}" class="action-btn detail">Detail</a>
                                <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="action-btn edit">Edit</a>
                                <form action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 italic text-gray-500">Belum ada data karyawan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script>
    $(document).ready(function () {
        $('#karyawan-table').DataTable({
            dom: '<"flex justify-between items-center mb-2"<"left-buttons"B><"right-search"f>>rtip',
            buttons: [
                { extend: 'copy', text: 'Salin', className: 'bg-gray-200 text-black px-3 py-1 rounded' },
                { extend: 'excel', text: 'Excel', className: 'bg-green-500 text-white px-3 py-1 rounded' },
                { extend: 'pdf', text: 'PDF', className: 'bg-red-500 text-white px-3 py-1 rounded' },
                { extend: 'print', text: 'Print', className: 'bg-blue-500 text-white px-3 py-1 rounded' }
            ]
        });
    });
</script>

@endsection