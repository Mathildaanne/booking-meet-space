@extends('layouts.admin')

@section('title', 'Ubah Password')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Ubah Password</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.password.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold">Password Lama</label>
            <input type="password" name="old_password" class="w-full border rounded px-3 py-2 mt-1" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Password Baru</label>
            <input type="password" name="new_password" class="w-full border rounded px-3 py-2 mt-1" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" class="w-full border rounded px-3 py-2 mt-1" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan
        </button>
    </form>
</div>
@endsection
