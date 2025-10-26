@extends('layouts.user')

@section('title', 'Riwayat Bookingku')

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
        text-transform: capitalize;
    }

    .status-approved {
        background-color: #d1fae5;
        color: #059669;
    }

    .status-pending,
    .status-active {
        background-color: #fef9c3;
        color: #b45309;
    }

    .status-finished {
        background-color: #d1fae5;
        color: #059669;
    }

    .status-rejected,
    .status-cancelled {
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

    .action-btn.cancel,
    .action-btn.delete {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    

</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-4">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-calendar-check text-blue-600"></i> Riwayat Booking Saya
        </h2>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg border border-green-200 mb-4 flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($bookings->isEmpty())
        <div class="text-gray-600 italic">Kamu belum melakukan booking ruangan.</div>
    @else
    <div class="bg-white border border-blue-500 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto p-4">
            <table id="jadwal-table" class="min-w-full divide-y divide-blue-500 text-sm">
                <thead class="bg-blue-200 text-left">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Ruangan</th>
                        <th class="px-6 py-3 font-semibold">Tanggal</th>
                        <th class="px-6 py-3 font-semibold">Waktu</th>
                        <th class="px-6 py-3 font-semibold">Keperluan</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $booking->ruang->nama }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('l, d F Y') }}</td>
                            <td class="px-6 py-4">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                            <td class="px-6 py-4">{{ $booking->keperluan ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="status-badge status-{{ strtolower($booking->status) }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-1">
                                <a href="{{ route('user.jadwal.show', $booking->id) }}" class="action-btn detail">Detail</a>
                                @if ($booking->status === 'active')
                                    <form action="{{ route('user.jadwal.destroy', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin membatalkan booking ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn cancel">Batalkan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

