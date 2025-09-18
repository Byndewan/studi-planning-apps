<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
            <p class="text-gray-600 mt-1">Informasi akun dan aktivitas terbaru</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('profile.edit') }}" class="btn-primary">
                <i class="fas fa-edit mr-2"></i>
                Edit Profil
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-8">
        <!-- Info Profil -->
        <div class="card card-hover">
            <div class="p-8">
                <div class="flex items-center space-x-6 mb-8">
                    <div class="flex-shrink-0">
                        <img class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-lg"
                             src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                             alt="{{ $user->name }}">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            Bergabung sejak {{ $user->created_at->format('F Y') }}
                        </p>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div class="bg-gray-50 rounded-lg p-4 text-center hover:bg-gray-100 transition-colors">
                        <i class="fas fa-calendar-alt text-blue-600 text-xl mb-2"></i>
                        <div class="text-gray-600">Semester Aktif</div>
                        <div class="font-semibold text-gray-900">{{ $user->currentSemester->name ?? 'Belum Ada' }}</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center hover:bg-gray-100 transition-colors">
                        <i class="fas fa-book text-green-600 text-xl mb-2"></i>
                        <div class="text-gray-600">Total MK</div>
                        <div class="font-semibold text-gray-900">{{ $user->courses_count ?? 0 }}</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center hover:bg-gray-100 transition-colors">
                        <i class="fas fa-check-double text-purple-600 text-xl mb-2"></i>
                        <div class="text-gray-600">Rencana Selesai</div>
                        <div class="font-semibold text-gray-900">{{ $user->completed_plans_count ?? 0 }}</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center hover:bg-gray-100 transition-colors">
                        <i class="fas fa-chart-line text-yellow-600 text-xl mb-2"></i>
                        <div class="text-gray-600">Sesi Monitoring</div>
                        <div class="font-semibold text-gray-900">{{ $user->study_sessions_count ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="card card-hover">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-history mr-2 text-blue-600"></i>
                    Aktivitas Terbaru
                </h3>

                <div class="space-y-3">
                    @if($recentActivities->count() > 0)
                        @foreach($recentActivities as $activity)
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-bolt text-blue-600 text-sm"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $activity['description'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="fas fa-clock text-gray-400 text-xs"></i>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-gray-400 text-3xl mb-3"></i>
                            <p class="text-gray-500">Belum ada aktivitas terbaru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="card card-hover">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-rocket mr-2 text-green-600"></i>
                    Aksi Cepat
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('courses.create') }}" class="flex items-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-plus text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Tambah Mata Kuliah</p>
                            <p class="text-xs text-gray-600">Kelola mata kuliah baru</p>
                        </div>
                    </a>
                    <a href="{{ route('monitorings.create') }}" class="flex items-center p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                        <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-chart-line text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Catat Monitoring</p>
                            <p class="text-xs text-gray-600">Pantau kemajuan belajar</p>
                        </div>
                    </a>
                    <a href="{{ route('sq3r.create') }}" class="flex items-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors">
                        <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-book-open text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Sesi SQ3R Baru</p>
                            <p class="text-xs text-gray-600">Mulai membaca aktif</p>
                        </div>
                    </a>
                    <a href="{{ route('concept-maps.create') }}" class="flex items-center p-4 bg-yellow-50 rounded-xl hover:bg-yellow-100 transition-colors">
                        <div class="w-10 h-10 bg-yellow-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-project-diagram text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Buat Peta Konsep</p>
                            <p class="text-xs text-gray-600">Visualisasikan pengetahuan</p>
                        </div>
                    </a>
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

        /* Icon animation */
        .group:hover .fa-calendar-alt,
        .group:hover .fa-book,
        .group:hover .fa-check-double,
        .group:hover .fa-chart-line,
        .group:hover .fa-history,
        .group:hover .fa-rocket {
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Quick action cards */
        .flex.items-center.p-4 {
            transition: all 0.3s ease;
        }

        .flex.items-center.p-4:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Activity item animation */
        .flex.items-center.space-x-3.p-3 {
            transition: all 0.2s ease;
        }

        .flex.items-center.space-x-3.p-3:hover {
            transform: translateX(4px);
        }
    </style>
</x-app-layout>
