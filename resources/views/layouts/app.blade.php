<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'StudyFlow') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50">
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <div class="p-6">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">StudyFlow</span>
                </a>
            </div>

            <nav class="flex-1 px-4 space-y-1">
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <x-icons.dashboard class="w-5 h-5" />
                    <span>Dashboard</span>
                </x-nav-link>

                <x-nav-link href="{{ route('semesters.index') }}" :active="request()->routeIs('semesters.*')">
                    <x-icons.calendar class="w-5 h-5" />
                    <span>Semesters</span>
                </x-nav-link>

                <x-nav-link href="{{ route('weekly-plans.index') }}" :active="request()->routeIs('weekly-plans.*')">
                    <x-icons.plan class="w-5 h-5" />
                    <span>Weekly Plans</span>
                </x-nav-link>

                <x-nav-link href="{{ route('monitorings.index') }}" :active="request()->routeIs('monitorings.*')">
                    <x-icons.monitor class="w-5 h-5" />
                    <span>Monitoring</span>
                </x-nav-link>

                <x-nav-link href="{{ route('sq3r.index') }}" :active="request()->routeIs('sq3r.*')">
                    <x-icons.book class="w-5 h-5" />
                    <span>SQ3R</span>
                </x-nav-link>

                <x-nav-link href="{{ route('concept-maps.index') }}" :active="request()->routeIs('concept-maps.*')">
                    <x-icons.map class="w-5 h-5" />
                    <span>Concept Maps</span>
                </x-nav-link>
            </nav>

            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center space-x-3">
                    <img class="w-10 h-10 rounded-full"
                         src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=6366f1&color=fff' }}"
                         alt="{{ Auth::user()->name }}">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <header class="bg-white border-b border-gray-200 px-8 py-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $header ?? '' }}</h1>
                    <div class="flex items-center space-x-3">
                        {{ $headerActions ?? '' }}
                    </div>
                </div>
            </header>

            <div class="p-8" id="app">
                {{ $slot }}
            </div>
        </main>
    </div>

    @if(session('success'))
        <x-toast type="success" message="{{ session('success') }}" />
    @endif

    @if(session('error'))
        <x-toast type="error" message="{{ session('error') }}" />
    @endif
</body>
</html>
