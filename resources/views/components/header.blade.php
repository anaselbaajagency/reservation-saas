<nav class="navbar navbar-expand-lg header-light bg-white responsive-sticky">
    <div class="container-fluid">
        <div class="col-auto col-lg-2 me-lg-0 me-auto">
            <a class="navbar-brand" href="demo-accounting.html">
                <img src="images/demo-accounting-logo-black.png" alt="Logo" class="default-logo">
            </a>
        </div>
        <button class="navbar-toggler float-start" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
            <span class="navbar-toggler-line"></span>
            <span class="navbar-toggler-line"></span>
            <span class="navbar-toggler-line"></span>
            <span class="navbar-toggler-line"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav"> 
            <ul class="navbar-nav fw-600">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li> 
                <li class="nav-item"><a href="demo-accounting-services.html" class="nav-link">Our experts</a></li>
                <li class="nav-item"><a href="demo-accounting-process.html" class="nav-link">Categories</a></li>
                <li class="nav-item"><a href="demo-accounting-news.html" class="nav-link">Blog</a></li> 
                <li class="nav-item"><a href="demo-accounting-contact.html" class="nav-link">Contact Us</a></li>
            </ul>
        </div>
        <div class="col-auto col-lg-2 text-end d-none d-sm-flex">
            @auth
                <!-- User dropdown when authenticated -->
                <div class="dropdown">
                    <button class="btn btn-transparent dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->profile_photo_path)
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 32px; height: 32px;">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 24px; height: 24px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><h6 class="dropdown-header">{{ Auth::user()->name }}</h6></li>
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <li><a class="dropdown-item" href="{{ route('api-tokens.index') }}">API Tokens</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <!-- Guest view with login button and user icon -->
                <div class="d-flex align-items-center">
                    <a href="{{ route('login') }}" class="text-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 24px; height: 24px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>