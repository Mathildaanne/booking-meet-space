@extends('layouts.admin')

@section('title', 'Laporan Booking')

@section('content')
<h3>Laporan Booking</h3>

<form method="GET" action="{{ route('admin.laporan.index') }}" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
        </div>
        <div class="col-md-4">
            <label>Bulan (YYYY-MM)</label>
            <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}">
        </div>
        <div class="col-md-4 mt-4">
            <button type="submit" class="btn btn-primary mt-2">Filter</button>
        </div>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Ruang</th>
            <th>Jumlah Booking</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rekap as $item)
        <tr>
            <td>{{ $item->ruang->nama ?? '-' }}</td>
            <td>{{ $item->total }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="2">Tidak ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
