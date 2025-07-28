<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Find Experts</h1>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('client.dashboard') }}" class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search Field -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                <input type="text" name="search" id="search"
                       value="{{ request('search') }}"
                       placeholder="Name, email or keywords"
                       class="w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600">
            </div>

            <!-- Specialty Filter -->
            <div>
                <label for="specialty" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Specialty</label>
                <select name="specialty" id="specialty" class="w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600">
                    <option value="">All Specialties</option>
                    @foreach($specialties as $specialty)
                        <option value="{{ $specialty->id }}" {{ request('specialty') == $specialty->id ? 'selected' : '' }}>
                            {{ $specialty->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex items-end">
                <button type="submit" class="w-full md:w-auto px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Search
                </button>
            </div>
        </div>
    </form>

    <!-- Experts List -->
    <div class="space-y-6">
        @forelse($experts as $expert)
            <div class="border rounded-lg p-6 hover:shadow-md transition dark:border-gray-700 dark:hover:shadow-gray-800">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Expert Photo -->
                    <div class="flex-shrink-0">
                        <img class="h-20 w-20 rounded-full object-cover"
                             src="{{ $expert->profile_photo_url ?? asset('images/default-avatar.png') }}"
                             alt="{{ $expert->name }}">
                    </div>

                    <!-- Expert Info -->
                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ $expert->name }}
                                </h3>
                                <p class="text-indigo-600 dark:text-indigo-400 mt-1">
                                    {{ optional($expert->expertProfile)->title ?? 'Professional Expert' }}
                                </p>
                            </div>
                            <a href="{{ route('client.expert.show', $expert->id) }}"
                               class="mt-3 md:mt-0 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                View Profile
                            </a>
                        </div>

                        <!-- Specialties -->
                        @if($expert->expertProfile && $expert->expertProfile->specialties->isNotEmpty())
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($expert->expertProfile->specialties as $specialty)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                        {{ $specialty->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Rating and Experience -->
                        <div class="mt-4 flex flex-col sm:flex-row sm:items-center gap-4">
                            @if($expert->expertProfile && $expert->expertProfile->rating_avg)
                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        @php $rating = round($expert->expertProfile->rating_avg); @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="h-5 w-5 {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                        <span class="ml-2 text-gray-600 dark:text-gray-400">
                                            {{ number_format($expert->expertProfile->rating_avg, 1) }} ({{ $expert->expertProfile->ratings_count ?? 0 }} reviews)
                                        </span>
                                    </div>
                                </div>
                            @endif

                            @if($expert->expertProfile && $expert->expertProfile->years_experience)
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <svg class="h-5 w-5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $expert->expertProfile->years_experience }}+ years experience
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-gray-600 dark:text-gray-400">No experts found matching your criteria.</p>
                @if(request()->hasAny(['search', 'specialty']))
                    <a href="{{ route('client.dashboard') }}" class="mt-4 inline-flex items-center text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">
                        Clear filters
                    </a>
                @endif
            </div>
        @endforelse

        <!-- Pagination -->
        @if($experts->hasPages())
            <div class="mt-8">
                {{ $experts->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>