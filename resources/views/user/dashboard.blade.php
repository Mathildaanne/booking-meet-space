@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')

<!-- Header -->
<div 
    class="mb-6 shadow text-white -mx-6 mx-10 px-6"
    style="background-image: url('{{ asset('images/user.png') }}'); min-height: 150px; background-size: cover; background-position: center;"
>
    <div class="relative z-10 p-6">
        <h3 class="text-2xl font-bold">Hello {{ Auth::user()->nama }}! 👋</h3>
        <p class="text-sm">Selamat Datang di Meet Space</p>
    </div>
</div>
    
<div class="px-6 lg:px-10">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- Card Date - Time -->
        <div class="bg-white rounded-lg shadow p-5 border border-gray-200 h-full">
            <div class="text-xs font-semibold text-gray-400 mb-1">Date - Time</div>
            <div id="current-date" class="text-sm font-semibold text-blue-600"></div>
            <div id="current-time" class="text-xs font-semibold text-blue-600 border-t border-gray-300 mt-2 pt-2"></div>
        </div>

            <script>
                function updateDateTime() {
                    const now = new Date();
            
                    // Konversi ke zona waktu Indonesia (UTC+7)
                    const optionsDate = { timeZone: 'Asia/Jakarta', year: 'numeric', month: 'long', day: '2-digit' };
                    const optionsTime = { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', hour12: true };
            
                    const tanggal = new Intl.DateTimeFormat('id-ID', optionsDate).format(now);
                    const waktu = new Intl.DateTimeFormat('en-US', optionsTime).format(now).replace(':', '.');
            
                    document.getElementById('current-date').textContent = tanggal;
                    document.getElementById('current-time').textContent = waktu;
                }
            
                // Jalankan langsung saat halaman dimuat
                updateDateTime();
            
                // Update otomatis setiap detik (real-time)
                setInterval(updateDateTime, 1000);
            </script>

        <!-- Card Jumlah Booking -->
        <div class="bg-white rounded-lg shadow p-5 border border-gray-200 h-full">
            <div class="text-xs font-semibold text-gray-400 mb-1">Jumlah Booking Aktif</div>
            <div class="flex items-center gap-2 text-blue-600 font-semibold text-2xl">
                <i class="fas fa-chair"></i> {{ $bookingAktif }}
            </div>
        </div>
    </div>
</div>

    
<div class="px-6 lg:px-10">
    <!-- Tata Cara Booking dan Upcoming Schedule -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Tata Cara Booking (ambil 2 kolom) -->
        <div class="bg-white rounded-lg shadow p-6 border border-gray-200 lg:col-span-2">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Tata Cara Melakukan Booking</h2>
            <ol class="list-decimal list-inside space-y-3 text-sm text-gray-700">
                <li>
                    <span class="font-semibold text-blue-600 hover:underline cursor-pointer">Lihat Jadwal Terlebih Dahulu</span><br>
                    <span class="text-gray-600">Buka halaman Jadwal di menu sebelah kiri untuk melihat ruang dan waktu yang sudah dibooking oleh pengguna lain.</span>
                </li>
                <li>
                    <span class="font-semibold text-blue-600 hover:underline cursor-pointer">Akses Menu Booking</span><br>
                    <span class="text-gray-600">Jika ingin melakukan booking, klik menu <b>Booking</b> → pilih submenu <b>Booking Ruang</b>.</span>
                </li>
                <li>
                    <span class="font-semibold text-blue-600 hover:underline cursor-pointer">Pilih Ruangan</span><br>
                    <span class="text-gray-600">Pada halaman booking, pilih ruangan yang ingin digunakan sesuai kebutuhan Anda.</span>
                </li>
                <li>
                    <span class="font-semibold text-blue-600 hover:underline cursor-pointer">Isi Formulir Booking</span><br>
                    <span class="text-gray-600">Klik tombol Booking, lalu isi seluruh data yang diminta seperti tanggal, waktu, dan keperluan penggunaan ruangan.</span>
                </li>
            </ol>
        </div>

        <!-- Upcoming Schedule (ambil 1 kolom) -->
        <div class="bg-white rounded-lg shadow p-5 border border-gray-200">
            <div class="text-xs font-semibold text-gray-600 mb-3">Upcoming Schedule</div>

                @if($upcoming->isEmpty())
                    <div class="text-sm text-gray-500">Tidak ada jadwal mendatang.</div>
                @else
                    <ul class="space-y-3 text-sm text-gray-700">
                        @foreach ($upcoming as $item)
                            <li class="flex items-center gap-3">
                                <div class="w-8 h-8 flex justify-center items-center rounded border border-blue-600 text-blue-600">
                                    <i class="fas fa-door-open text-xs"></i>
                                </div>
                                <div>
                                    <span class="font-semibold text-blue-600 hover:underline">
                                        {{ $item->ruang->nama }} - {{ $item->nama }}
                                    </span>
                                    <div class="text-xs text-gray-400">
                                        {{ \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y') }} |
                                        {{ $item->jam_mulai }} - {{ $item->jam_selesai }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>



@endsection
