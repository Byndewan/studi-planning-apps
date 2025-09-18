<nav x-data="{ open: false }" class="bg-white/95 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo dengan animasi halus -->
            <div class="flex items-center space-x-3 group">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300 group-hover:scale-105">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-semibold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
                        StudyFlow
                    </span>
                </a>
            </div>

            <!-- Navigation Links dengan hover effect -->
            <div class="hidden space-x-2 sm:flex">
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="group">
                    <i class="fas fa-tachometer-alt mr-2 text-sm group-hover:animate-pulse"></i>
                    {{ __('Beranda') }}
                </x-nav-link>
                <x-nav-link href="{{ route('semesters.index') }}" :active="request()->routeIs('semesters.*')" class="group">
                    <i class="fas fa-calendar-alt mr-2 text-sm group-hover:animate-pulse"></i>
                    {{ __('Semester') }}
                </x-nav-link>
                <x-nav-link href="{{ route('weekly-plans.index') }}" :active="request()->routeIs('weekly-plans.*')" class="group">
                    <i class="fas fa-calendar-week mr-2 text-sm group-hover:animate-pulse"></i>
                    {{ __('Rencana Mingguan') }}
                </x-nav-link>
                <x-nav-link href="{{ route('monitorings.index') }}" :active="request()->routeIs('monitorings.*')" class="group">
                    <i class="fas fa-chart-line mr-2 text-sm group-hover:animate-pulse"></i>
                    {{ __('Monitoring') }}
                </x-nav-link>
                <x-nav-link href="{{ route('sq3r.index') }}" :active="request()->routeIs('sq3r.*')" class="group">
                    <i class="fas fa-book-open mr-2 text-sm group-hover:animate-pulse"></i>
                    {{ __('SQ3R') }}
                </x-nav-link>
                <x-nav-link href="{{ route('concept-maps.index') }}" :active="request()->routeIs('concept-maps.*')" class="group">
                    <i class="fas fa-project-diagram mr-2 text-sm group-hover:animate-pulse"></i>
                    {{ __('Peta Konsep') }}
                </x-nav-link>
            </div>

            <!-- User Menu dengan dropdown animasi -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-50 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-medium text-sm group-hover:scale-110 transition-transform">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- User Info Header -->
                        <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-blue-50">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-medium">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-1">
                            <x-dropdown-link href="{{ route('profile.show') }}" class="flex items-center space-x-3 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 transition-all duration-200">
                                <i class="fas fa-user text-gray-400 w-4 text-center"></i>
                                <span>{{ __('Profil Saya') }}</span>
                            </x-dropdown-link>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center space-x-3 text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                    <i class="fas fa-sign-out-alt w-4 text-center"></i>
                                    <span>{{ __('Keluar') }}</span>
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition-all duration-200">
                    <svg class="h-6 w-6 transform transition-transform duration-300" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-gradient-to-b from-white to-gray-50">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="flex items-center space-x-3">
                <i class="fas fa-tachometer-alt w-4 text-center text-blue-500"></i>
                {{ __('Beranda') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('semesters.index') }}" :active="request()->routeIs('semesters.*')" class="flex items-center space-x-3">
                <i class="fas fa-calendar-alt w-4 text-center text-green-500"></i>
                {{ __('Semester') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('weekly-plans.index') }}" :active="request()->routeIs('weekly-plans.*')" class="flex items-center space-x-3">
                <i class="fas fa-calendar-week w-4 text-center text-purple-500"></i>
                {{ __('Rencana Mingguan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('monitorings.index') }}" :active="request()->routeIs('monitorings.*')" class="flex items-center space-x-3">
                <i class="fas fa-chart-line w-4 text-center text-orange-500"></i>
                {{ __('Monitoring') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('sq3r.index') }}" :active="request()->routeIs('sq3r.*')" class="flex items-center space-x-3">
                <i class="fas fa-book-open w-4 text-center text-indigo-500"></i>
                {{ __('SQ3R') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('concept-maps.index') }}" :active="request()->routeIs('concept-maps.*')" class="flex items-center space-x-3">
                <i class="fas fa-project-diagram w-4 text-center text-red-500"></i>
                {{ __('Peta Konsep') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 bg-gradient-to-b from-gray-50 to-white">
            <div class="px-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-medium">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('profile.show') }}" class="flex items-center space-x-3">
                    <i class="fas fa-user w-4 text-center"></i>
                    {{ __('Profil Saya') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center space-x-3 text-red-600 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt w-4 text-center"></i>
                        <span>{{ __('Keluar') }}</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    <!-- Animasi untuk dropdown -->
    <style>
        .dropdown-enter {
            animation: dropdownEnter 0.2s ease-out;
        }

        @keyframes dropdownEnter {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Smooth transitions untuk semua elemen */
        .nav-link, .dropdown-link, .responsive-nav-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Hover effect untuk nav links */
        .nav-link:hover {
            transform: translateX(4px);
        }

        /* Active indicator */
        .nav-link.active {
            position: relative;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 0 2px 2px 0;
        }
    </style>
</nav>
