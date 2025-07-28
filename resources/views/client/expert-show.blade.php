<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 lg:p-8">

                <!-- Back button -->
                <a href="{{ route('client.dashboard') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 mb-6">
                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to search
                </a>

                <!-- Expert Header -->
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Photo -->
                    <div class="flex-shrink-0">
                        <img class="h-64 w-70 rounded-b-4xl object-cover" 
                             src="{{ $expert->profile_photo_url ?? asset('images/default-avatar.png') }}" 
                             alt="{{ $expert->name }}">
                    </div>

                    <!-- Info -->
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $expert->name }}</h1>
                        <p class="text-xl text-indigo-600 dark:text-indigo-400 mt-1">
                            {{ optional($expert->expertProfile)->title ?? 'Expert in ' . optional($expert->expertProfile->specialties->first())->name }}
                        </p>

                        <!-- Rating -->
                        @if($expert->expertProfile && $expert->expertProfile->rating_avg)
                        <div class="mt-3 flex items-center">
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

                        <!-- Hourly Rate -->
                        @if($expert->expertProfile && $expert->expertProfile->hourly_rate)
                        <div class="mt-3 text-gray-600 dark:text-gray-400">
                            <strong>From:</strong> {{ number_format($expert->expertProfile->hourly_rate, 0) }} MAD / 45 minutes
                        </div>
                        @endif

                        <!-- Specialties Badges -->
                        @if($expert->expertProfile && $expert->expertProfile->specialties->isNotEmpty())
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($expert->expertProfile->specialties as $specialty)
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $specialty->name }}
                                </span>
                            @endforeach
                        </div>
                        @endif

                        <!-- Call to Action -->
                        <p class="mt-4 text-gray-700 dark:text-gray-300">
                            Réservez votre consultation avec {{ $expert->name }}, expert(e) reconnu(e) en 
                            {{ optional($expert->expertProfile)->specialties->pluck('name')->join(', ') ?? 'votre domaine' }}.
                        </p>

                        <a href="{{ route('reservations.create', $expert->id) }}" 
                           class="inline-block mt-6 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition duration-200">
                            Reserve Now
                        </a>
                    </div>
                </div>

                <!-- About Section -->
                @if($expert->expertProfile && $expert->expertProfile->biography)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">About me</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($expert->expertProfile->biography)) !!}
                    </div>
                </div>
                @endif

                <!-- Experience & Certifications -->
                @if(($expert->expertProfile && $expert->expertProfile->years_of_experience) || 
                    ($expert->expertProfile && $expert->expertProfile->certifications))
                <div class="mt-12 grid md:grid-cols-2 gap-6">
                    <!-- Experience -->
                    @if($expert->expertProfile && $expert->expertProfile->years_of_experience)
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Years of Experience</h2>
                        <p class="text-gray-700 dark:text-gray-300">
                            {{ $expert->expertProfile->years_of_experience }} years
                        </p>
                    </div>
                    @endif

                    <!-- Certifications -->
                    @if($expert->expertProfile && $expert->expertProfile->certifications)
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Certifications</h2>
                        <p class="text-gray-700 dark:text-gray-300">
                            {{ $expert->expertProfile->certifications }}
                        </p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Languages -->
                @if($expert->expertProfile && $expert->expertProfile->languages)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Languages Spoken</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $expert->expertProfile->languages) as $lang)
                            @if(trim($lang))
                            <span class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-full text-gray-800 dark:text-gray-200">
                                {{ ucfirst(trim($lang)) }}
                            </span>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>