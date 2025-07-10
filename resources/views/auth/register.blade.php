<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-image: url('/images/latar.png');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    {{-- Header --}}
    <div class="flex justify-between items-center bg-white px-2 py-1 shadow-sm mb-4">
        <img src="/images/logo.png" alt="Logo" class="h-12">
        <a href="{{ route('login') }}" class="bg-blue-900 text-white text-xs px-4 py-2 rounded">Login</a>
    </div>

    {{-- Sign Up Form --}}
    <div class="flex flex-1 justify-center items-center">
        <div class="bg-white/70 backdrop-blur-md p-10 rounded-xl shadow-md w-full max-w-md text-center">
            <h1 class="text-2xl font-semibold text-blue-900 mb-6">Register</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4 text-left">
                    <label for="nama" class="block text-sm font-semibold text-gray-700">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                        class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring">
                    @error('nama') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4 text-left">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring">
                    @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4 text-left">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring">
                    @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6 text-left">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full mt-1 p-2 border rounded focus:outline-none focus:ring">
                </div>

                <button type="submit" class="bg-blue-900 text-white w-full py-2 rounded hover:bg-blue-800">
                    Register
                </button>
            </form>

            <p class="mt-4 text-sm text-gray-600">Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-700 hover:underline">Sign In</a>
            </p>
        </div>
    </div>
</body>
</html>
