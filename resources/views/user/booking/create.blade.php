@extends('layouts.user')

@section('title', 'Booking Ruangan')

@section('content')
<div class="px-6 lg:px-10">
    <h2 class="text-xl font-bold mb-4">Booking Ruangan: {{ $ruang->nama }}</h2>

    {{-- Form pilih tanggal --}}
    <form method="GET" class="mb-4">
        <input type="hidden" name="ruang" value="{{ $ruang->id }}">
        <label for="tanggal" class="font-semibold">Pilih Tanggal:</label>
        <input type="date" name="tanggal" value="{{ $selectedDate }}" class="border px-2 py-1 rounded" onchange="this.form.submit()">
    </form>

    {{-- Tabel Jadwal Booking --}}
    <div class="mb-4">
        <h3 class="font-semibold mb-2">Jadwal pada {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</h3>
        @if ($bookings->isEmpty())
            <p class="text-sm text-gray-600 italic">Belum ada booking pada tanggal ini.</p>
        @else
        <table class="table-auto w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">Nama</th>
                    <th class="border px-2 py-1">Jam Mulai</th>
                    <th class="border px-2 py-1">Jam Selesai</th>
                    <th class="border px-2 py-1">Keperluan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $b)
                <tr>
                    <td class="border px-2 py-1">{{ $b->nama }}</td>
                    <td class="border px-2 py-1">{{ $b->jam_mulai }}</td>
                    <td class="border px-2 py-1">{{ $b->jam_selesai }}</td>
                    <td class="border px-2 py-1">{{ $b->keperluan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <div class="max-w-2xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-6 text-center">Form Booking Meeting Room</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6 text-lg">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('bookings.store') }}" class="bg-white p-8 rounded-xl shadow-md border border-blue-400">
        @csrf
        <input type="hidden" name="ruang_id" value="{{ $ruang->id }}">

        {{-- Pilih Ruangan --}}
        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2 text-lg">Ruangan</label>
            <p class="text-base font-medium">{{ $ruang->nama }}</p>
        </div>


        {{-- Nama Lengkap --}}
        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2 text-lg">Nama Lengkap</label>
            <input type="text" name="nama" class="w-full border rounded-lg p-3 text-base focus:outline-none focus:ring focus:border-blue-400">
        </div>

        {{-- Jumlah Orang --}}
        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2 text-lg">Jumlah Orang</label>
            <select name="jumlah_orang" class="w-full border rounded-lg p-3 text-base focus:outline-none focus:ring focus:border-blue-400">
                @for ($i = 1; $i <= $ruang->kapasitas; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        {{-- Tanggal --}}
        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2 text-lg">Tanggal</label>
            <input type="date" name="tanggal_booking" value="{{ old('tanggal_booking') }}" required
                   class="w-full border rounded-lg p-3 text-base focus:outline-none focus:ring focus:border-blue-400">
        </div>

        {{-- Jam Mulai dan Selesai --}}
        <div class="flex gap-6 mb-5">
            <div class="w-1/2">
                <label class="block text-gray-700 font-semibold mb-2 text-lg">Jam Mulai</label>
                <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" required
                       class="w-full border rounded-lg p-3 text-base focus:outline-none focus:ring focus:border-blue-400">
            </div>
            <div class="w-1/2">
                <label class="block text-gray-700 font-semibold mb-2 text-lg">Jam Selesai</label>
                <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" required
                       class="w-full border rounded-lg p-3 text-base focus:outline-none focus:ring focus:border-blue-400">
            </div>
        </div>

        {{-- Keperluan --}}
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2 text-lg">Keperluan</label>
            <textarea name="keperluan" rows="4"
                      class="w-full border rounded-lg p-3 text-base focus:outline-none focus:ring focus:border-blue-400"
                      placeholder="Contoh: Rapat Divisi, Presentasi Produk, dll...">{{ old('keperluan') }}</textarea>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-4">
            <a href="{{ Route::has('bookings.index') ? route('bookings.index') : '#' }}"
               class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 text-base font-semibold rounded shadow">
                Batal
            </a>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 text-base font-semibold rounded shadow">
                Submit
            </button>
        </div>
    </form>
</div>
</div>
@endsection
