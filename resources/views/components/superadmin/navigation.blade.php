<nav class="bg-gray-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <x-jet-nav-link href="{{ route('superadmin.dashboard') }}" :active="request()->routeIs('superadmin.*')">
                Dashboard
            </x-jet-nav-link>
            
            @can('manage users')
            <x-jet-nav-link href="{{ route('superadmin.users') }}">
                User Management
            </x-jet-nav-link>
            @endcan
            
            <!-- Add more superadmin-specific links -->
        </div>
    </div>
</nav>