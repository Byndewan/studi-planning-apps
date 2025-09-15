<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Study Planner') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar Navigation -->
        <nav x-data="{ open: false }" class="bg-white border-b md:border-b-0 md:border-r border-gray-200 md:w-64">
            <div class="px-4 py-3 md:px-6">
                <div class="flex justify-between items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-gray-800 flex items-center">
                        <x-application-mark class="w-8 h-8 mr-2" />
                        Study Planner
                    </a>

                    <!-- Mobile menu button -->
                    <button @click="open = !open" class="md:hidden p-2 rounded-md text-gray-600 hover:text-gray-800 hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <div :class="{'block': open, 'hidden': !open}" class="md:block mt-4 md:mt-6">
                    <div class="space-y-1 md:space-y-2">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <x-icons.dashboard class="w-5 h-5" />
                            <span>Dashboard</span>
                        </x-nav-link>

                        <x-nav-link :href="route('semesters.index')" :active="request()->routeIs('semesters.*')">
                            <x-icons.calendar class="w-5 h-5" />
                            <span>Semesters</span>
                        </x-nav-link>

                        <x-nav-link :href="route('weekly-plans.index')" :active="request()->routeIs('weekly-plans.*')">
                            <x-icons.plan class="w-5 h-5" />
                            <span>Weekly Plans</span>
                        </x-nav-link>

                        <x-nav-link :href="route('monitorings.index')" :active="request()->routeIs('monitorings.*')">
                            <x-icons.monitor class="w-5 h-5" />
                            <span>Monitoring</span>
                        </x-nav-link>

                        <x-nav-link :href="route('sq3r.index')" :active="request()->routeIs('sq3r.*')">
                            <x-icons.book class="w-5 h-5" />
                            <span>SQ3R</span>
                        </x-nav-link>

                        <x-nav-link :href="route('concept-maps.index')" :active="request()->routeIs('concept-maps.*')">
                            <x-icons.map class="w-5 h-5" />
                            <span>Concept Maps</span>
                        </x-nav-link>
                    </div>

                    <!-- Responsive user menu -->
                    <div class="pt-4 pb-3 border-t border-gray-200 mt-4">
                        <div class="flex items-center px-4">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ Auth::user()->name }}">
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <x-responsive-nav-link :href="route('profile.show')">
                                Profile
                            </x-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-responsive-nav-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Log Out
                                </x-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1 overflow-auto">
            <!-- Page Heading -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ $header ?? '' }}
                    </h2>

                    <div class="flex space-x-4">
                        {{ $headerActions ?? '' }}
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    <!-- Toast Notifications -->
    @if(session('success'))
        <x-toast type="success" message="{{ session('success') }}" />
    @endif

    @if(session('error'))
        <x-toast type="error" message="{{ session('error') }}" />
    @endif
</body>
</html>
