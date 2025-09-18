<x-app-layout>
    <x-slot name="header">
        <div class="animate-fadeInUp">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                Selamat datang, {{ auth()->user()->name }}
            </h1>
            <p class="text-gray-600 mt-2 text-base">
                Ringkasan kemajuan belajar Anda hari ini
            </p>
        </div>
    </x-slot>

    <div class="space-y-8 animate-fadeInUp delay-100">
        <!-- Stats Grid dengan animasi smooth -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Semester Card -->
            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-600">Semester Aktif</p>
                            <p class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                {{ $currentSemester->name ?? 'Belum Ada' }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300 group-hover:scale-110">
                            <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span>Semester berjalan</span>
                    </div>
                </div>
            </div>

            <!-- Courses Card -->
            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-600">Mata Kuliah</p>
                            <p class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">
                                {{ $coursesCount }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-green-50 to-green-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300 group-hover:scale-110">
                            <i class="fas fa-book text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <i class="fas fa-book-open mr-2"></i>
                        <span>Total mata kuliah</span>
                    </div>
                </div>
            </div>

            <!-- Progress Card -->
            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-600">Kemajuan</p>
                            <p class="text-3xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">
                                {{ $completionRate }}%
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300 group-hover:scale-110">
                            <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 h-2 rounded-full transition-all duration-1000 ease-out"
                                 style="width: {{ $completionRate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks Card -->
            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-600">Tugas</p>
                            <p class="text-3xl font-bold text-gray-900 group-hover:text-red-600 transition-colors">
                                {{ $upcomingTasks }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-red-50 to-red-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300 group-hover:scale-110">
                            <i class="fas fa-tasks text-red-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <i class="fas fa-clock mr-2"></i>
                        <span>Perlu diselesaikan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Activity -->
            <div class="lg:col-span-2">
                <div class="card card-hover">
                    <div class="card-header">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-history mr-3 text-blue-600"></i>
                                Aktivitas Terbaru
                            </h2>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($recentActivities as $activity)
                            <div class="p-6 hover:bg-gray-50/50 transition-all duration-200 group">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm group-hover:shadow-md transition-all duration-300">
                                        <i class="fas fa-bolt text-blue-600 group-hover:animate-bounce"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-700 transition-colors">
                                            {{ $activity['title'] }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $activity['description'] }}</p>
                                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ $activity['time'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-bell-slash text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada aktivitas</h3>
                                <p class="text-gray-600 text-sm">Aktivitas belajar Anda akan muncul di sini</p>
                                <a href="{{ route('courses.create') }}" class="btn-primary mt-4">
                                    <i class="fas fa-plus mr-2"></i>
                                    Mulai Belajar
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Upcoming Deadlines -->
                <div class="card mt-6 card-hover">
                    <div class="card-header">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-calendar-check mr-3 text-green-600"></i>
                                Jadwal Mendatang
                            </h2>
                            <span class="text-sm text-gray-500">{{ now()->format('F Y') }}</span>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($upcomingDeadlines as $deadline)
                            <div class="p-4 hover:bg-gray-50/50 transition-all duration-200  group">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-red-50 to-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-flag text-red-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 group-hover:text-red-700 transition-colors">
                                                {{ $deadline['title'] }}
                                            </p>
                                            <p class="text-xs text-gray-600">{{ $deadline['course'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-medium px-3 py-1 rounded-full {{ $deadline['urgent'] ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-blue-100 text-blue-800 border border-blue-200' }}">
                                            <i class="far fa-calendar mr-1"></i>
                                            {{ $deadline['date'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada jadwal</h3>
                                <p class="text-gray-600 text-sm">Nikmati waktu luang Anda</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Progress -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="card card-hover">
                    <div class="card-header">
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-rocket mr-3 text-purple-600"></i>
                            Aksi Cepat
                        </h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('sq3r.create') }}" class="group flex items-center p-4 rounded-xl border border-gray-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 hover:border-blue-300">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                                <i class="fas fa-book-open text-white text-lg"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-700">Mulai SQ3R</p>
                                <p class="text-xs text-gray-600 mt-1">Metode membaca aktif</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition-colors"></i>
                        </a>

                        <a href="{{ route('concept-maps.create') }}" class="group flex items-center p-4 rounded-xl border border-gray-200 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all duration-300 hover:border-green-300">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                                <i class="fas fa-project-diagram text-white text-lg"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-green-700">Buat Peta Konsep</p>
                                <p class="text-xs text-gray-600 mt-1">Visualisasikan pengetahuan</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-600 transition-colors"></i>
                        </a>

                        <a href="{{ route('monitorings.create') }}" class="group flex items-center p-4 rounded-xl border border-gray-200 hover:bg-gradient-to-r hover:from-yellow-50 hover:to-orange-50 transition-all duration-300 hover:border-yellow-300">
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                                <i class="fas fa-chart-line text-white text-lg"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-yellow-700">Catat Progress</p>
                                <p class="text-xs text-gray-600 mt-1">Monitoring belajar</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-yellow-600 transition-colors"></i>
                        </a>
                    </div>
                </div>

                <!-- Progress Overview -->
                <div class="card card-hover">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-trophy mr-3 text-yellow-600"></i>
                            Ringkasan
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check-circle text-green-600 text-sm"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Rencana Selesai</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $completedPlans }} / {{ $totalPlans }}</span>
                            </div>

                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-book text-blue-600 text-sm"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Sesi Belajar</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $studySessionsCount }}</span>
                            </div>

                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-lightbulb text-purple-600 text-sm"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Peta Konsep</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $conceptMapsCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Card hover animation */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Progress bar animation */
        .progress-fill {
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Icon animation */
        .group:hover .fa-tachometer-alt,
        .group:hover .fa-calendar-alt,
        .group:hover .fa-calendar-week,
        .group:hover .fa-chart-line,
        .group:hover .fa-book-open,
        .group:hover .fa-project-diagram {
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Smooth entrance animation */
        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Button hover effect */
        .btn-primary {
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        /* Gradient text */
        .bg-gradient-text {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s both`;
            });

            const statCards = document.querySelectorAll('.group');
            statCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.querySelector('.text-3xl').style.transform = 'scale(1.05)';
                });

                card.addEventListener('mouseleave', function() {
                    this.querySelector('.text-3xl').style.transform = 'scale(1)';
                });
            });
        });
    </script>

</x-app-layout>
