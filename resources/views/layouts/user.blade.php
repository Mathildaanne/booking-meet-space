<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard User')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@headlessui/react@1.4.2/dist/headlessui.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @yield('styles')

</head>
<body class="bg-gray-100 text-gray-800" x-data="{ sidebarOpen: false }">
<div class="flex min-h-screen">
    <!-- Sidebar -->
     @php
        $route = Route::currentRouteName();
        $isBookingOpen = Str::startsWith($route, 'bookings.');
    @endphp

    <aside
        class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform transition-transform duration-200 ease-in-out lg:static lg:translate-x-0"
        :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
    >
        <div class="flex items-center justify-between p-4 border-b border-gray-200 shadow-sm lg:justify-start">
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 mr-3">
                <span class="text-2xl font-bold text-blue-800">Meet Space</span>
            </div>
            <!-- Close Button (mobile) -->
            <button class="lg:hidden text-gray-500" @click="sidebarOpen = false">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-3 text-sm" x-data="{ openBooking: {{ $isBookingOpen ? 'true' : 'false' }} }">
            <!-- Home -->
            <div>
                <h2 class="text-xs font-semibold text-gray-500 uppercase mb-1">Home</h2>
                <a href="{{ route('user.dashboard') }}"
                class="flex items-center py-2 px-4 rounded-lg transition
                        {{ $route === 'user.dashboard' ? 'bg-blue-500 text-white hover:bg-blue-600' : 'text-blue-500 hover:bg-blue-100' }}">
                    <i class="fas fa-th-large w-5 mr-3 {{ $route === 'user.dashboard' ? 'text-white' : 'text-blue-500' }}"></i>
                    Dashboard
                </a>
            </div>

            <!-- Pages -->
            <div>
                <h2 class="text-xs font-semibold text-gray-500 uppercase mt-4 mb-1">Pages</h2>

                <!-- Booking Dropdown -->
                <button @click="openBooking = !openBooking"
                        class="flex items-center py-2 px-4 rounded justify-between w-full hover:bg-blue-100 text-blue-500">
                    <div class="flex items-center">
                        <i class="fas fa-chair w-5 mr-3"></i> Booking
                    </div>
                    <i :class="openBooking ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-sm"></i>
                </button>

                <div x-show="openBooking" x-cloak class="pl-8 mt-1 space-y-1">
                    <a href="{{ route('bookings.index') }}"
                        class="block py-1 px-2 rounded text-sm font-medium transition
                            {{ $route === 'bookings.index' ? 'bg-blue-500 text-white' : 'text-blue-500 hover:bg-blue-600 hover:text-white' }}">
                        Booking Ruang
                    </a>
                </div>

                <!-- Jadwal utama (bisa dihapus kalau sudah ada di dropdown) -->
                <a href="{{ route('user.jadwal.index') }}"
                class="flex items-center py-2 px-4 rounded-lg transition
                        {{ $route === 'user.jadwal.index' ? 'bg-blue-500 text-white hover:bg-blue-600' : 'text-blue-500 hover:bg-blue-100' }}">
                    <i class="fas fa-calendar-alt w-5 mr-3 {{ $route === 'jadwal.index' ? 'text-white' : 'text-blue-500' }}"></i>
                    Jadwal Ku
                </a>
            </div>

            <!-- User -->
            <div>
                <h2 class="text-xs font-semibold text-gray-500 uppercase mt-4 mb-1">User</h2>

                <a href="{{ route('user.jadwal.riwayat') }}"
                class="flex items-center py-2 px-4 rounded-lg transition
                        {{ $route === 'user.jadwal.riwayat' ? 'bg-blue-500 text-white hover:bg-blue-600' : 'text-blue-500 hover:bg-blue-100' }}">
                    <i class="fas fa-calendar-day w-5 mr-3 {{ $route === 'user.jadwal.riwayat' ? 'text-white' : 'text-blue-500' }}"></i>
                    Riwayat
                </a>
            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button
                    type="submit"
                    class="flex items-center gap-3 w-full px-4 py-2 rounded-xl shadow-sm bg-red-50 hover:bg-red-100 transition duration-200"
                >
                    <div class="bg-red-100 text-red-600 rounded-md p-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-9V4m0 0H5a2 2 0 00-2 2v12a2 2 0 002 2h8" />
                        </svg>
                    </div>
                    <span class="text-red-600 font-medium">Logout</span>
                </button>
            </form>
        </nav>           

    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Topbar -->
        <header class="flex items-center justify-between px-4 py-3 bg-white shadow-md">
            <!-- Mobile: Sidebar Toggle -->
            <button class="lg:hidden text-gray-500" @click="sidebarOpen = true">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Center: Search -->
            <div class="hidden md:flex flex-1 justify-center px-4">
                <div class="relative w-full max-w-md">
                    <input
                        type="text"
                        placeholder="Search..."
                        class="w-full pl-10 pr-4 py-2 rounded-md border border-gray-300 focus:ring focus:ring-blue-100 focus:outline-none"
                    >
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Right: User Info -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                    <img src="{{ asset('storage/foto/' . Auth::user()->foto) }}" class="w-15 h-10 rounded-full" alt="User">
                    <div class="hidden md:block text-right">
                        <div class="text-sm font-medium">{{ Auth::user()->nama }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->jabatan ?? 'User' }}</div>
                    </div>
                </button>

                <!-- Dropdown -->
                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    @click.away="open = false"
                    x-cloak
                    class="absolute right-0 mt-2 w-52 bg-white rounded-lg shadow-xl z-50 overflow-hidden"
                >
                    <div class="px-4 py-3 border-b bg-gray-50">
                        <div class="font-semibold text-sm text-gray-800">{{ Auth::user()->nama }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->jabatan ?? 'User' }}</div>
                    </div>

                    <ul class="py-1 text-sm text-gray-700">
                        <li>
                            <a href="{{ route('user.profile') }}" class="flex items-center px-4 py-2 hover:bg-gray-100 transition">
                                <i class="fas fa-user mr-2 w-4"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.password.edit') }}" class="flex items-center px-4 py-2 hover:bg-gray-100 transition">
                                <i class="fas fa-key mr-2 w-4"></i> Ubah Password
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.settings') }}" class="flex items-center px-4 py-2 hover:bg-gray-100 transition">
                                <i class="fas fa-cog mr-2 w-4"></i> Pengaturan
                            </a>
                        </li>
                    </ul>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition flex items-center">
                            <i class="fas fa-sign-out-alt mr-2 w-4"></i> Logout
                        </button>
                    </form>
                </div>

            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 bg-gray-50">
            @yield('content')
        </main>
    </div>
</div>

    @yield('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
