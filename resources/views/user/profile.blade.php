@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Profil Saya</h2>

    <div class="flex items-center space-x-4 mb-6">
        <img src="{{ asset('storage/foto/' . Auth::user()->foto) }}" class="w-25 h-20" alt="Avatar">
        <div>
            <h3 class="text-xl font-semibold">{{ Auth::user()->nama }}</h3>
            <p class="text-gray-600">{{ Auth::user()->email }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 text-sm text-gray-700">
        <div>
            <strong>Nama:</strong> {{ Auth::user()->nama }}
        </div>
        <div>
            <strong>Email:</strong> {{ Auth::user()->email }}
        </div>
        <div>
            <strong>Role:</strong> {{ Auth::user()->role }}
        </div>
    </div>
</div>
@endsection
