<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
    <div class="flex justify-between items-center bg-white px-2 py-1 shadow-sm">
        <img src="/images/logo.png" alt="Logo" class="h-12">
        <a href="{{ route('register') }}" class="bg-blue-900 text-white text-xs px-4 py-2 rounded">Register</a>
    </div>

    {{-- Sign In Form --}}
    <div class="flex flex-1 justify-center items-center">
        <div class="bg-white/70 backdrop-blur-md p-10 rounded-xl shadow-md w-full max-w-md text-center">
            <h1 class="text-2xl font-semibold text-blue-900 mb-6">Login</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

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

                <div class="flex items-center mb-4 text-left">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    <label for="remember" class="text-sm text-gray-700">Remember me</label>
                </div>

                <button type="submit" class="bg-blue-900 text-white w-full py-2 rounded hover:bg-blue-800">
                    Sign In
                </button>
            </form>

            <div class="mt-4 flex justify-between text-sm text-gray-600">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="hover:underline">Forgot Password?</a>
                @endif
                <a href="{{ route('register') }}" class="hover:underline">Sign Up</a>
            </div>
        </div>
    </div>
</body>
</html>
