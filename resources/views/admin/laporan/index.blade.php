@extends('layouts.admin')

@section('title', 'Admin - Laporan Booking')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<style>
    .summary-section {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .summary-card {
        flex: 1 1 30%;
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.06);
        border: 1px solid #e5e7eb;
        transition: 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-4px);
        border-color: #3b82f6;
    }

    .summary-icon {
        font-size: 28px;
        margin-bottom: 8px;
        display: inline-block;
        color: #3b82f6;
    }

    .summary-title {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 6px;
    }

    .summary-value {
        font-size: 24px;
        font-weight: bold;
        color: #111827;
    }

    .cancel-icon {
        color: red;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        border: 1px solid #dee2e6;
        padding: 12px;
        vertical-align: middle;
        font-size: 14px;
        color: #212529;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .card {
        background: #ffffff;
        border-radius: 12px;
    }

    .shadow-sm {
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .dt-button {
        font-size: 0.875rem;
        font-weight: 600;
        padding: 0.4rem 1rem;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #1f2937;
        margin-right: 0.5rem;
        transition: 0.2s;
    }

    .dt-button:hover {
        background-color: #e5e7eb;
    }

    .dt-button.buttons-excel {
        background-color: #10b981;
        color: white;
    }

    .dt-button.buttons-pdf {
        background-color: #ef4444;
        color: white;
    }

    .dt-button.buttons-print {
        background-color: #3b82f6;
        color: white;
    }

    .dt-button.buttons-copy {
        background-color: #6b7280;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="summary-section mb-4">
        <div class="summary-card">
            <div class="summary-icon"><i class="fas fa-door-open"></i></div>
            <div class="summary-title">Total Pemakaian Ruangan</div>
            <div class="summary-value">{{ $totalPenggunaan }}</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon"><i class="fas fa-user"></i></div>
            <div class="summary-title">Total Pengguna</div>
            <div class="summary-value">{{ $totalUser }}</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon cancel-icon"><i class="fas fa-times-circle"></i></div>
            <div class="summary-title">Pembatalan</div>
            <div class="summary-value cancel-icon">{{ $totalBatal }}</div>
        </div>
    </div>

    <div class="card mt-4 p-3 shadow-sm">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="bi bi-calendar-event-fill text-blue-600"></i> Data Laporan Booking
        </h2>

        <table id="laporan-table" class="table table-bordered text-sm">
            <thead class="bg-light">
                <tr>
                    <th>Nama Peminjam</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Keperluan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $item)
                    <tr>
                        <td>{{ $item->user->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_booking)->translatedFormat('d F Y') }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                        </td>
                        <td>{{ $item->keperluan ?? '-' }}</td>
                        <td>
                            @if ($item->status === 'finished')
                                <span class="badge bg-success">Finished</span>
                            @elseif ($item->status === 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.booking.detail', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Tidak ada data booking tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
  $(document).ready(function() {
    $('#laporan-table').DataTable({
        dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>rt<"d-flex justify-content-between mt-3"lip>',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Salin',
                className: 'dt-button buttons-copy',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'dt-button buttons-excel',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'dt-button buttons-pdf',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'dt-button buttons-print',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ],
        language: {
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data",
            lengthMenu: "Tampilkan _MENU_ data",
            search: "Cari:",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        }
    });
});
</script>
@endsection
