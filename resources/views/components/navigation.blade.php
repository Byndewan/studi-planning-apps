<nav x-data="{ open: false }" class="bg-white">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-auto">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-15 w-15" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:flex ml-5 py-6">
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link href="{{ route('semesters.index') }}" :active="request()->routeIs('semesters.*')">
                    {{ __('Semesters') }}
                </x-nav-link>
                <x-nav-link href="{{ route('weekly-plans.index') }}" :active="request()->routeIs('weekly-plans.*')">
                    {{ __('Weekly Plans') }}
                </x-nav-link>
                <x-nav-link href="{{ route('monitorings.index') }}" :active="request()->routeIs('monitorings.*')">
                    {{ __('Monitoring') }}
                </x-nav-link>
                <x-nav-link href="{{ route('sq3r.index') }}" :active="request()->routeIs('sq3r.*')">
                    {{ __('SQ3R') }}
                </x-nav-link>
                <x-nav-link href="{{ route('concept-maps.index') }}" :active="request()->routeIs('concept-maps.*')">
                    {{ __('Concept Maps') }}
                </x-nav-link>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center space-x-2 p-2 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            <!-- Foto profil -->
                            <div
                                class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>

                            <!-- Nama user (hanya tampil di desktop) -->
                            <div class="hidden md:block text-sm font-medium text-gray-700">
                                {{ Auth::user()->name }}
                            </div>

                            <!-- Icon panah -->
                            <div class="text-gray-400">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Header dropdown dengan info user -->
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Account') }}
                        </div>

                        <x-dropdown-link href="{{ route('profile.show') }}" class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ __('Profile') }}</span>
                        </x-dropdown-link>

                        <div class="border-t border-gray-100"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center space-x-2 text-red-600 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                <span>{{ __('Log Out') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:text-gray-500 focus:bg-gray-100 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Responsive Navigation Menu -->
            <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('semesters.index') }}" :active="request()->routeIs('semesters.*')">
                        {{ __('Semesters') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('weekly-plans.index') }}" :active="request()->routeIs('weekly-plans.*')">
                        {{ __('Weekly Plans') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('monitorings.index') }}" :active="request()->routeIs('monitorings.*')">
                        {{ __('Monitoring') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('sq3r.index') }}" :active="request()->routeIs('sq3r.*')">
                        {{ __('SQ3R') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('concept-maps.index') }}" :active="request()->routeIs('concept-maps.*')">
                        {{ __('Concept Maps') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                    src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name= ' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                    alt="{{ Auth::user()->name }}">
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link href="{{ route('profile.show') }}">
                            {{ __('Profile') }}
                        </x-responsive-nav-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
