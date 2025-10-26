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
        <div class="flex justify-between items-center mb-2">
            <h3 class="font-semibold">Jadwal pada {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</h3>
            <button onclick="openModal()" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold">
                Booking
            </button>
        </div>
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

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6 text-lg flex items-center gap-2">
            <i class="fas fa-check-circle text-green-600"></i>
            {{ session('success') }}
        </div>
    @endif
</div>

<!-- Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 hover:text-red-600 text-2xl font-bold">&times;</button>
        
        <div class="p-6 overflow-y-auto max-h-[90vh]">
            <h1 class="text-2xl font-bold mb-4 text-center">Form Booking Meeting Room</h1>

        <form method="POST" action="{{ route('bookings.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="ruang_id" value="{{ $ruang->id }}">

            <div>
                <label class="block font-semibold mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                    class="w-full border rounded p-2 required">
            </div>

            <div>
                <label class="block font-semibold mb-1">Jumlah Orang</label>
                <select name="jumlah_orang" class="w-full border rounded p-2">
                    @for ($i = 1; $i <= $ruang->kapasitas; $i++)
                        <option value="{{ $i }}" {{ old('jumlah_orang') == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Tanggal</label>
                <input type="date" name="tanggal_booking" value="{{ old('tanggal_booking') }}"
                    class="w-full border rounded p-2 @error('tanggal_booking') border-red-500 @enderror" required>
                @error('tanggal_booking')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="block font-semibold mb-1">Jam Mulai</label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}"
                        class="w-full border rounded p-2 @error('jam_mulai') border-red-500 @enderror" required>
                    @error('jam_mulai')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-1/2">
                    <label class="block font-semibold mb-1">Jam Selesai</label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}"
                        class="w-full border rounded p-2 @error('jam_selesai') border-red-500 @enderror" required>
                    @error('jam_selesai')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block font-semibold mb-1">Keperluan</label>
                <textarea name="keperluan" rows="3" class="w-full border rounded p-2" required>{{ old('keperluan') }}</textarea>
                @error('keperluan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" onclick="closeModal()"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim</button>
            </div>
        </form>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openModal() {
        document.getElementById('bookingModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('bookingModal').classList.add('hidden');
    }

    // Jika ada error validasi, otomatis buka modal
    @if ($errors->any())
        document.addEventListener("DOMContentLoaded", function() {
            openModal();
        });
    @endif
</script>
@endsection
