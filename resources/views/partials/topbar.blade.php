<header class="flex items-center justify-between px-6 py-3 bg-white border-b border-gray-200 sticky top-0 z-10">
    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 lg:hidden focus:outline-none">
        <i class="fas fa-bars text-xl"></i>
    </button>
    <form class="flex items-center w-full max-w-md mx-6">
        <div class="relative w-full">
            <input type="search" placeholder="Search now" class="w-full rounded-full border border-gray-300 bg-gray-100 py-2 pl-10 pr-4 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <div class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </form>
    <div class="ml-auto">
        <img src="https://storage.googleapis.com/a1aa/image/2654d07f-5a90-49e4-c586-95d88dc5cdf3.jpg" class="w-10 h-10 rounded-full border object-cover" alt="Avatar">
    </div>
</header>