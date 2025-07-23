@extends('jetstream::layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <!-- Back button -->
                <a href="{{ route('client.dashboard') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 mb-4">
                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to search
                </a>
                
                <!-- Expert Profile Header -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <img class="h-16 w-16 rounded-full" 
                             src="{{ $expert->profile_photo_url }}" 
                             alt="{{ $expert->name }}">
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $expert->name }}</h2>
                        <p class="text-gray-600 dark:text-gray-400">{{ $expert->email }}</p>
                        
                        <!-- Rating -->
                        <div class="mt-2 flex items-center">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="h-5 w-5 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                                <span class="ml-1 text-gray-600 dark:text-gray-400">4.0 (12 reviews)</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Expert Details -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Domains -->
                    <div class="col-span-1">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Domains</h3>
                        <div class="space-y-2">
                            @foreach($expert->domains as $domain)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                    {{ $domain->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Secteurs -->
                    <div class="col-span-1">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Secteurs</h3>
                        <div class="space-y-2">
                            @foreach($expert->secteurs as $secteur)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    {{ $secteur->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Contact Button -->
                    <div class="col-span-1">
                        <button class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Contact Expert
                        </button>
                    </div>
                </div>
                
                <!-- Additional Expert Information -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">About</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection