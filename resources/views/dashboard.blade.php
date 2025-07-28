<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                @if(isset($welcome) && $welcome)
                    {{-- Default Jetstream Welcome Content --}}
                    <div class="p-6 lg:p-8 bg-white dark:bg-gray-800">
                        <x-application-logo class="block h-12 w-auto" />

                        <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                            Welcome to your Jetstream application!
                        </h1>

                        <div class="mt-6 space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <p class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                                    Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application.
                                </p>
                            </div>
                            <!-- Include all the other welcome content sections here -->
                        </div>
                    </div>
                @else
                    {{-- Dynamic Content Based on Route --}}
                    @auth
                        @if(request()->is('client/expert/*'))
                            {{-- Expert Profile View --}}
                            @include('client.expert-show')
                        @elseif(request()->is('reservations/create/*'))
                            {{-- Reservation create --}}
                            @include('reservations.create')
                        @else
                            {{-- Role-based Dashboard --}}
                            @if(auth()->user()->hasRole('superadmin'))
                                @include('superadmin.dashboard')
                            @elseif(auth()->user()->hasRole('admin'))
                                @include('admin.dashboard')
                            @elseif(auth()->user()->hasRole('expert'))
                                @include('expert.dashboard')
                            @elseif(auth()->user()->hasRole('membre_validation'))
                                @include('membre_validation.dashboard')
                            @else
                                {{-- Default Client Dashboard --}}
                                @include('client.dashboard')   
                            @endif
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</x-app-layout>