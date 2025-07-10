<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard User')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@headlessui/react@1.4.2/dist/headlessui.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

@php
    $route = Route::currentRouteName();

    // untuk dropdown
    $isUsersOpen = Str::startsWith($route, 'admin.karyawan.');
    $isRuanganOpen = Str::startsWith($route, 'admin.ruang.');
    $isBookingOpen = Str::startsWith($route, 'admin.booking.');
    $isLaporanOpen = Str::startsWith($route, 'admin.laporan.');

    // untuk menu non-dropdown
    $isDashboardActive = $route === 'admin.dashboard';
    $isLaporanActive = Str::startsWith($route, 'admin.laporan.');
    $isJadwalActive = Str::startsWith($route, 'admin.booking.');
@endphp

<body class="bg-gray-100 text-gray-800"
      x-data="{
          sidebarOpen: false,
          openUsers: {{ $isUsersOpen ? 'true' : 'false' }},
          openRuangan: {{ $isRuanganOpen ? 'true' : 'false' }},
          openBooking: {{ $isBookingOpen ? 'true' : 'false' }},
          openLaporan: {{ $isLaporanOpen ? 'true' : 'false' }}
      }">

<div class="flex min-h-screen">
    <!-- Sidebar -->
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
        <nav class="p-4 space-y-1 text-sm">
            <a href="{{ route('admin.dashboard') }}"
            class="flex items-center py-2 px-4 rounded-lg font-medium transition 
                {{ $isDashboardActive ? 'bg-blue-600 text-white' : 'text-blue-600 hover:bg-blue-600 hover:text-white' }}">
                <i class="fas fa-th-large w-5 mr-3"></i> Dashboard
            </a>

            <!-- Users Dropdown -->
            <button @click="openUsers = !openUsers"
                    class="flex items-center py-2 px-4 rounded justify-between w-full hover:bg-blue-100 text-blue-600 font-medium">
                <div class="flex items-center">
                    <i class="fas fa-user w-5 mr-3"></i> Users
                </div>
                <i :class="openUsers ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-sm"></i>
            </button>

            <div x-show="openUsers" x-cloak class="pl-8 mt-1 space-y-1">
                <a href="{{ route('admin.karyawan.index') }}"
                class="block py-1 px-2 rounded text-sm font-medium transition 
                    {{ $route === 'admin.karyawan.index' ? 'bg-blue-600 text-white' : 'text-blue-600 hover:bg-blue-600 hover:text-white' }}">
                    Daftar Karyawan
                </a>
                <a href="{{ route('admin.karyawan.create') }}"
                class="block py-1 px-2 rounded text-sm font-medium transition 
                    {{ $route === 'admin.karyawan.create' ? 'bg-blue-600 text-white' : 'text-blue-600 hover:bg-blue-600 hover:text-white' }}">
                    Tambah Karyawan
                </a>
            </div>

            <a href="{{ route('admin.booking.index') }}"
            class="flex items-center py-2 px-4 rounded-lg font-medium transition 
                {{ $isJadwalActive ? 'bg-blue-600 text-white' : 'text-blue-600 hover:bg-blue-600 hover:text-white' }}">
                <i class="fas fa-calendar-alt w-5 mr-3"></i> Jadwal
            </a>

            <!-- Ruangan Dropdown -->
            <button @click="openRuangan = !openRuangan"
                    class="flex items-center py-2 px-4 rounded justify-between w-full hover:bg-blue-100 text-blue-600 font-medium">
                <div class="flex items-center">
                    <i class="fas fa-door-open w-5 mr-3"></i> Ruangan
                </div>
                <i :class="openRuangan ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-sm"></i>
            </button>

            <div x-show="openRuangan" x-cloak class="pl-8 mt-1 space-y-1">
                <a href="{{ route('admin.ruang.index') }}"
                class="block py-1 px-2 rounded text-sm font-medium transition 
                    {{ $route === 'admin.ruang.index' ? 'bg-blue-600 text-white' : 'text-blue-600 hover:bg-blue-600 hover:text-white' }}">
                    Daftar Ruangan
                </a>
                <a href="{{ route('admin.ruang.create') }}"
                class="block py-1 px-2 rounded text-sm font-medium transition 
                    {{ $route === 'admin.ruang.create' ? 'bg-blue-600 text-white' : 'text-blue-600 hover:bg-blue-600 hover:text-white' }}">
                    Tambah Ruangan
                </a>
            </div>

            <a href="{{ route('admin.laporan.index') }}"
            class="flex items-center py-2 px-4 rounded-lg font-medium transition 
                {{ $isLaporanActive ? 'bg-blue-600 text-white' : 'text-blue-600 hover:bg-blue-600 hover:text-white' }}">
                <i class="fas fa-file-alt w-5 mr-3"></i> Laporan
            </a>

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
            <div class="flex items-center space-x-3">
                <img src="https://i.pravatar.cc/40?img=3" class="w-10 h-10 rounded-full" alt="User">
                <div class="hidden md:block text-right">
                    <div class="text-sm font-medium">Austin Robertson</div>
                    <div class="text-xs text-gray-500">Marketing Administrator</div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 bg-gray-50">
            @yield('content')
        </main>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>

