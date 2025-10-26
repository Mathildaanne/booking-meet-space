@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Profil Saya</h1>
    <div class="mb-4">
        <img src="{{ asset('storage/foto/' . Auth::user()->foto) }}" class="w-24 h-24 rounded-full mb-2" alt="Foto Profil">
        <div><strong>Nama:</strong> {{ Auth::user()->nama }}</div>
        <div><strong>Email:</strong> {{ Auth::user()->email }}</div>
        <div><strong>Jabatan:</strong> {{ Auth::user()->nama }}</div>
        <div><strong>Role:</strong> {{ Auth::user()->nama }}</div>
    </div>
    <a href="{{ route('admin.password') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ubah Password</a>
</div>
@endsection
