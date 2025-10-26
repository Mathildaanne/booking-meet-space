@extends('layouts.admin')

@section('title', 'Admin - Jadwal Booking')

@section('styles')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .status-badge {
        padding: 4px 12px;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 12px;
        display: inline-block;
    }

    .status-approved {
        background-color: #d1fae5;
        color: #059669;
    }

    .status-pending {
        background-color: #fef9c3;
        color: #b45309;
    }

    .status-rejected {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .status-active {
        background-color: #fef9c3;
        color: #b45309;
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

    .action-btn.delete {
        background-color: #fee2e2;
        color: #b91c1c;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-4">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-calendar-alt text-blue-600"></i> Jadwal Booking
        </h2>
    </div>

    <!-- Tabel -->
    <div class="bg-white border border-blue-500 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-blue-500 text-sm" id="jadwalTable">
                <thead class="bg-blue-200 text-left">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-black-700">Ruangan</th>
                        <th class="px-6 py-3 font-semibold text-black-700">Peminjam</th>
                        <th class="px-6 py-3 font-semibold text-black-700">Tanggal</th>
                        <th class="px-6 py-3 font-semibold text-black-700">Waktu</th>
                        <th class="px-6 py-3 font-semibold text-black-700">Status</th>
                        <th class="px-6 py-3 font-semibold text-black-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black-100">
                    @forelse ($bookings as $booking)
                    <tr data-status="{{ $booking->status }}">
                        <td class="px-6 py-4">{{ $booking->ruang->nama }}</td>
                        <td class="px-6 py-4">{{ $booking->user->nama }}</td>
                        <td class="px-6 py-4">{{ $booking->tanggal_booking }}</td>
                        <td class="px-6 py-4">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                        <td class="px-6 py-4 space-x-1 whitespace-nowrap">
                            <span class="status-badge status-{{ strtolower($booking->status) }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 space-x-1 whitespace-nowrap">
                            <a href="{{ route('admin.booking.detail', $booking->id) }}" class="action-btn detail">Detail</a>
                            @if($booking->status === 'active')
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#cancelModal{{ $booking->id }}">Batalkan</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500 italic">Tidak ada booking ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Pembatalan (di luar table) -->
@foreach ($bookings as $booking)
@if($booking->status === 'active')
<div class="modal fade" id="cancelModal{{ $booking->id }}" tabindex="-1"
    aria-labelledby="cancelModalLabel{{ $booking->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel{{ $booking->id }}">Konfirmasi Pembatalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="alasanPembatalan" class="form-label">Alasan Pembatalan</label>
                        <textarea name="alasan_pembatalan" class="form-control" rows="3" required
                            placeholder="Contoh: Ruangan dipakai rapat mendadak"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection
