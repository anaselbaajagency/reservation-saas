{{-- Client Dashboard Content (to be included in main dashboard) --}}
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Find Experts</h1>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('dashboard') }}" class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search by Name/Email -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>  
                <input type="text" name="search" id="search"
                       value="{{ request('search') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600">
            </div>

            <!-- Filter by Specialty -->
            <div>
                <label for="specialty" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Specialty</label>
                <select name="specialty" id="specialty" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600">
                    <option value="">All Specialties</option>
                    @if(isset($specialties))
                        @foreach($specialties as $specialty)
                            <option value="{{ $specialty->id }}" {{ request('specialty') == $specialty->id ? 'selected' : '' }}>
                                {{ $specialty->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">       
                    Search
                </button>
            </div>
        </div>
    </form>

    <!-- Experts List -->
    <div class="space-y-4">
        @if(isset($experts) && $experts->count() > 0)
            @foreach($experts as $expert)
                <div class="border rounded-lg p-4 hover:shadow-md transition dark:border-gray-700">
                    <div class="flex items-start">
                        <!-- Expert Photo -->
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full"
                                 src="{{ $expert->profile_photo_url ?? '/default-avatar.png' }}"
                                 alt="{{ $expert->name }}">
                        </div>

                        <!-- Expert Info -->
                        <div class="ml-4 flex-1">
                            <div class="flex justify-between">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $expert->name }}
                                </h3>
                                <a href="{{ route('client.expert.show', $expert) }}"
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">
                                    View Profile
                                </a>
                            </div>

                            <!-- Specialties -->
                            <div class="mt-2">
                                @if(isset($expert->expertProfile) && $expert->expertProfile->specialties)
                                    @foreach($expert->expertProfile->specialties as $specialty)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 mr-1">
                                            {{ $specialty->name }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Rating (optional) -->
                            <div class="mt-2 flex items-center">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="h-4 w-4 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                    <span class="ml-1 text-sm text-gray-600 dark:text-gray-400">4.0</span>
                                </div>
                                <span class="mx-2 text-gray-300 dark:text-gray-600">|</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">12 reviews</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            @if(method_exists($experts, 'links'))
                <div class="mt-4">
                    {{ $experts->appends(request()->query())->links() }}
                </div>
            @endif
        @elseif(isset($experts))
            <p class="text-gray-600 dark:text-gray-400">No experts found matching your criteria.</p>
        @else
            <p class="text-gray-600 dark:text-gray-400">Loading experts...</p>
        @endif
    </div>
</div>