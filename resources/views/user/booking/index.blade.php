@extends('layouts.user')

@section('title', 'Booking Ruang Meeting')

@section('content')

<!-- <div 
    class="mb-6 shadow text-white -mx-6 mx-10 px-6"
    style="background-image: url('{{ asset('images/06.png') }}'); min-height: 150px; background-size: cover; background-position: center;"
>
    <div class="relative z-10 p-6">
        <h3 class="text-2xl font-bold">Booking Ruang Meeting</h3>
        <p class="text-sm">Pilih ruangan yang ingin digunakan sesuai kebutuhan Anda</p>
    </div>
</div> -->

    <div 
    class="mb-6 shadow text-white"
    style="background-image: url('{{ asset('images/user.png') }}'); min-height: 150px; background-size: cover; background-position: center;"
    >
    <div class="relative z-10 p-6">
        <h3 class="text-2xl font-bold">Booking Ruang Meeting</h3>
        <p class="text-sm">Pilih ruangan yang ingin digunakan sesuai kebutuhan Anda</p>
    </div>
    </div>

    <div class="px-6 lg:px-10">
        <div class="flex flex-col gap-4">
            @foreach ($ruangans as $ruang)
                <div class="flex bg-white rounded shadow border overflow-hidden">
                    <img src="{{ asset('storage/' . $ruang->foto) }}" alt="{{ $ruang->nama }}"
                        class="w-64 h-36 object-cover mt-4 mb-4 lg:px-4 rounded-xl">   

                    <div class="flex-1 p-4 flex flex-col justify-between">
                        <div>
                            <h4 class="font-semibold text-lg text-gray-800">{{ $ruang->nama }}</h4>
                            <p class="text-sm text-gray-500">
                                Kapasitas: {{ $ruang->kapasitas }} orang <br>
                                Fasilitas: {{ $ruang->fasilitas }} <br>
                                Lantai: {{ $ruang->lantai ?? '-' }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between mt-2">
                            <a href="{{ route('jadwal.show', $ruang->id) }}"
                                class="text-sm text-green-600 font-medium hover:underline">Lihat Jadwal</a>

                            @if (in_array($ruang->id, $bookedRuangIds))
                                <div class="flex gap-2 items-center">
                                    <span class="text-sm text-red-500 font-semibold">Sedang digunakan</span>
                                    <form action="{{ route('booking.destroy', $ruang->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin membatalkan booking?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white px-3 py-1 text-sm rounded hover:bg-red-600">
                                            Batalkan
                                        </button>
                                    </form>
                                </div>
                            @else
                                <a href="{{ route('booking.create', ['ruang' => $ruang->id]) }}"
                                    class="bg-white text-blue-600 border border-blue-400 font-semibold px-4 py-1.5 text-sm rounded-md shadow hover:bg-blue-50 transition">
                                    Booking
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
