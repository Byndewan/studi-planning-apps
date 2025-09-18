<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $course->code }} - {{ $course->name }}</h1>
                <p class="text-gray-600 mt-1">{{ $course->semester->name }}</p>
            </div>
            <x-slot name="headerActions">
                <a href="{{ route('courses.edit', $course) }}" class="btn-primary">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('semesters.show', $course->semester) }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </x-slot>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Course Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Kode</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $course->code }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-hashtag text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">SKS</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">{{ $course->sks }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-green-50 to-green-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-coins text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Modul</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors">{{ $course->total_modules }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-layer-group text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Status</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">Aktif</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-play-circle text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card card-hover">
                <div class="card-header">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-calendar-week mr-3 text-blue-600"></i>
                            Rencana Mingguan
                        </h3>
                        <a href="{{ route('weekly-plans.create') }}?course_id={{ $course->id }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            <i class="fas fa-plus mr-1"></i>
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-600">Total Rencana</span>
                        <span class="text-2xl font-bold text-gray-900">{{ $course->weeklyPlans->count() }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-400 to-blue-500 h-2 rounded-full transition-all duration-1000"
                             style="width: {{ $course->weeklyPlans->where('status', 'completed')->count() / max($course->weeklyPlans->count(), 1) * 100 }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        {{ $course->weeklyPlans->where('status', 'completed')->count() }} dari {{ $course->weeklyPlans->count() }} rencana selesai
                    </p>
                </div>
            </div>

            <div class="card card-hover">
                <div class="card-header">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-chart-line mr-3 text-green-600"></i>
                            Monitoring
                        </h3>
                        <a href="{{ route('monitorings.create') }}?course_id={{ $course->id }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                            <i class="fas fa-plus mr-1"></i>
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-600">Total Sesi</span>
                        <span class="text-2xl font-bold text-gray-900">{{ $course->monitorings->count() }}</span>
                    </div>
                    <div class="space-y-2">
                        @php
                            $achieved = $course->monitorings->where('achieved', true)->count();
                            $total = $course->monitorings->count();
                            $percentage = $total > 0 ? ($achieved / $total) * 100 : 0;
                        @endphp
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-600">Tercapai</span>
                            <span class="font-medium text-green-600">{{ $achieved }} ({{ round($percentage) }}%)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-green-400 to-green-500 h-2 rounded-full transition-all duration-1000"
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-hover">
                <div class="card-header">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-book-open mr-3 text-purple-600"></i>
                            SQ3R Sessions
                        </h3>
                        <a href="{{ route('sq3r.create') }}?course_id={{ $course->id }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                            <i class="fas fa-plus mr-1"></i>
                            Baru
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-600">Total Sesi</span>
                        <span class="text-2xl font-bold text-gray-900">{{ $course->sq3rSessions->count() }}</span>
                    </div>
                    @if($course->sq3rSessions->isNotEmpty())
                        <div class="space-y-2">
                            @php
                                $completed = $course->sq3rSessions->where('review_notes', '!=', '')->count();
                                $total = $course->sq3rSessions->count();
                                $percentage = $total > 0 ? ($completed / $total) * 100 : 0;
                            @endphp
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-600">Selesai</span>
                                <span class="font-medium text-purple-600">{{ $completed }} ({{ round($percentage) }}%)</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-purple-400 to-purple-500 h-2 rounded-full transition-all duration-1000"
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Belum ada sesi SQ3R</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        {{-- @if($recentActivities->isNotEmpty())
            <div class="card card-hover">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-history mr-3 text-blue-600"></i>
                        Aktivitas Terbaru
                    </h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($recentActivities as $activity)
                        <div class="p-6 hover:bg-gray-50/50 transition-all duration-200">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-bolt text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">{{ $activity['title'] }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $activity['description'] }}</p>
                                    <p class="text-xs text-gray-500 mt-2">{{ $activity['time'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif --}}

        <!-- Action Buttons -->
        <div class="flex justify-between items-center p-6 bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl border border-gray-200">
            <div>
                <p class="text-sm text-gray-600">Terakhir diperbarui: {{ $course->updated_at->diffForHumans() }}</p>
            </div>
            <div class="flex space-x-3">
                <form action="{{ route('courses.destroy', $course) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini? Semua data terkait akan ikut terhapus.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary bg-red-50 text-red-600 hover:bg-red-100 border-red-200">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus
                    </button>
                </form>
                <a href="{{ route('courses.edit', $course) }}" class="btn-primary">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Mata Kuliah
                </a>
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

        /* Button animation */
        .btn-animate {
            position: relative;
            overflow: hidden;
        }

        .btn-animate::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .btn-animate:hover::before {
            left: 100%;
        }
    </style>

    <script>
        // Add smooth animations to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s both`;
            });

            // Add hover effects to stat cards
            const statCards = document.querySelectorAll('.group');
            statCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.querySelector('.text-2xl').style.transform = 'scale(1.05)';
                });

                card.addEventListener('mouseleave', function() {
                    this.querySelector('.text-2xl').style.transform = 'scale(1)';
                });
            });
        });
    </script>
</x-app-layout>
