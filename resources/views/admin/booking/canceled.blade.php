@extends('layouts.admin')

@section('title', 'Booking Dibatalkan Admin')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-green-600 mb-4">Booking Berhasil!</h2>
    <p class="mb-4">Permintaan booking ruangmu telah berhasil dikirim. Kamu akan menerima email jika diperlukan.</p>
    <a href="{{ route('user.dashboard') }}"
       class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        Kembali ke Dashboard
    </a>
</div>
@endsection
