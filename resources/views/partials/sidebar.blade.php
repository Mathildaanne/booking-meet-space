<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed z-30 inset-y-0 left-0 w-64 bg-white border-r border-gray-200 transform lg:translate-x-0 transition-transform duration-200 ease-in-out">
    <div class="flex items-center gap-2 px-6 py-5 border-b border-gray-200">
        <div class="text-2xl text-blue-700"><i class="fas fa-comments"></i></div>
        <div class="text-lg font-semibold text-gray-900">Meet Space</div>
    </div>
    <nav class="px-4 py-6 space-y-6">
        <div>
            <h3 class="text-xs font-semibold text-gray-400 uppercase mb-2">Home</h3>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-sm font-medium text-white bg-blue-600 rounded px-3 py-2">
                        <i class="fas fa-th-large text-sm"></i> Dashboard
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>

<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>