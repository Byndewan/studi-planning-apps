<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $course->code }} - {{ $course->name }}
                </h1>
                <p class="text-gray-600 mt-1 text-base">{{ $course->semester->name }}</p>
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
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                {{ $course->code }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
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
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">
                                {{ $course->sks }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-50 to-green-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
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
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors">
                                {{ $course->total_modules }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
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
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">
                                Aktif</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-play-circle text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Modules Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Weekly Plans with Detail Modal -->
            <div class="card card-hover">
                <div class="card-header">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-calendar-week mr-3 text-blue-600"></i>
                            Rencana Mingguan
                        </h3>
                        <a href="{{ route('weekly-plans.create') }}?course_id={{ $course->id }}"
                            class="text-sm text-blue-600 hover:text-blue-700 font-medium">
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
                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden mb-4">
                        <div class="bg-gradient-to-r from-blue-400 to-blue-500 h-2 rounded-full transition-all duration-1000"
                            style="width: {{ ($course->weeklyPlans->where('status', 'completed')->count() / max($course->weeklyPlans->count(), 1)) * 100 }}%">
                        </div>
                    </div>

                    @if ($course->weeklyPlans->isNotEmpty())
                        <div class="space-y-3 max-h-64 overflow-y-auto">
                            @foreach ($course->weeklyPlans->take(5) as $plan)
                                <a href="{{ route('weekly-plans.show' , $plan->id ) }}">
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer"
                                        onclick="openModal('weekly-plan-{{ $plan->id }}')">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Minggu
                                                {{ $plan->week_number }}</p>
                                            <p class="text-xs text-gray-600">{{ Str::limit($plan->target_text, 30) }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span
                                                class="status-badge text-xs {{ $plan->status === 'completed' ? 'bg-green-100 text-green-800' : ($plan->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                                {{ ucfirst(str_replace('_', ' ', $plan->status)) }}
                                            </span>
                                            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                            @if ($course->weeklyPlans->count() > 5)
                                <p class="text-xs text-gray-500 text-center mt-2">
                                    +{{ $course->weeklyPlans->count() - 5 }} rencana lainnya</p>
                            @endif
                        </div>
                        <button onclick="openModal('all-weekly-plans')"
                            class="w-full mt-4 text-sm text-blue-600 hover:text-blue-800 font-medium">
                            <i class="fas fa-list mr-1"></i> Lihat Semua Rencana
                        </button>
                    @else
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada rencana mingguan</p>
                    @endif
                </div>
            </div>

            <!-- Monitoring with Detail Modal -->
            <div class="card card-hover">
                <div class="card-header">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-chart-line mr-3 text-green-600"></i>
                            Monitoring Belajar
                        </h3>
                        <a href="{{ route('monitorings.create') }}?course_id={{ $course->id }}"
                            class="text-sm text-green-600 hover:text-green-700 font-medium">
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

                    @if ($course->monitorings->isNotEmpty())
                        @php
                            $achieved = $course->monitorings->where('achieved', true)->count();
                            $total = $course->monitorings->count();
                            $percentage = $total > 0 ? ($achieved / $total) * 100 : 0;
                        @endphp
                        <div class="space-y-3 max-h-64 overflow-y-auto">
                            @foreach ($course->monitorings->take(5) as $monitoring)
                                <a href="{{ route('monitorings.show' , $monitoring->id) }}">
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer"
                                        onclick="openModal('monitoring-{{ $monitoring->id }}')">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $monitoring->date->format('d M Y') }}</p>
                                            <p class="text-xs text-gray-600">Minggu {{ $monitoring->week_number }}</p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span
                                                class="status-badge text-xs {{ $monitoring->achieved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $monitoring->achieved ? 'Tercapai' : 'Tidak Tercapai' }}
                                            </span>
                                            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                            @if ($course->monitorings->count() > 5)
                                <p class="text-xs text-gray-500 text-center mt-2">
                                    +{{ $course->monitorings->count() - 5 }} sesi lainnya</p>
                            @endif
                        </div>
                        <button onclick="openModal('all-monitoring')"
                            class="w-full mt-4 text-sm text-green-600 hover:text-green-800 font-medium">
                            <i class="fas fa-list mr-1"></i> Lihat Semua Monitoring
                        </button>
                    @else
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada sesi monitoring</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- SQ3R Sessions with Detail Modal -->
        <div class="card card-hover">
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-book-open mr-3 text-purple-600"></i>
                        Sesi SQ3R
                    </h3>
                    <a href="{{ route('sq3r.create') }}?course_id={{ $course->id }}"
                        class="text-sm text-purple-600 hover:text-purple-700 font-medium">
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

                @if ($course->sq3rSessions->isNotEmpty())
                    @php
                        $completed = $course->sq3rSessions->where('review_notes', '!=', '')->count();
                        $total = $course->sq3rSessions->count();
                        $percentage = $total > 0 ? ($completed / $total) * 100 : 0;
                    @endphp
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach ($course->sq3rSessions->take(5) as $session)
                            <a href="{{ route('sq3r-sessions.show' , $session->id) }}">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer"
                                    onclick="openModal('sq3r-{{ $session->id }}')">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $session->module_title }}</p>
                                        <p class="text-xs text-gray-600">{{ $session->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="status-badge text-xs {{ $session->review_notes ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $session->review_notes ? 'Selesai' : 'Dalam Proses' }}
                                        </span>
                                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        @if ($course->sq3rSessions->count() > 5)
                            <p class="text-xs text-gray-500 text-center mt-2">
                                +{{ $course->sq3rSessions->count() - 5 }} sesi lainnya</p>
                        @endif
                    </div>
                    <button onclick="openModal('all-sq3r')"
                        class="w-full mt-4 text-sm text-purple-600 hover:text-purple-800 font-medium">
                        <i class="fas fa-list mr-1"></i> Lihat Semua Sesi SQ3R
                    </button>
                @else
                    <p class="text-sm text-gray-500 text-center py-4">Belum ada sesi SQ3R</p>
                @endif
            </div>
        </div>

        <!-- Concept Maps with Detail Modal -->
        <div class="card card-hover">
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-project-diagram mr-3 text-yellow-600"></i>
                        Peta Konsep
                    </h3>
                    <a href="{{ route('concept-maps.create') }}?course_id={{ $course->id }}"
                        class="text-sm text-yellow-600 hover:text-yellow-700 font-medium">
                        <i class="fas fa-plus mr-1"></i>
                        Baru
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-gray-600">Total Peta</span>
                    <span class="text-2xl font-bold text-gray-900">{{ $course->conceptMaps->count() }}</span>
                </div>

                @if ($course->conceptMaps->isNotEmpty())
                    @php
                        $nodes = [];
                        $edges = [];
                        foreach ($course->conceptMaps as $map) {
                            $mapNodes = is_array($map->nodes) ? $map->nodes : json_decode($map->nodes, true) ?? [];
                            $mapEdges = is_array($map->edges) ? $map->edges : json_decode($map->edges, true) ?? [];
                            $nodes = array_merge($nodes, $mapNodes);
                            $edges = array_merge($edges, $mapEdges);
                        }
                    @endphp
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach ($course->conceptMaps->take(5) as $map)
                            <a href="{{ route('concept-maps.show' , $map) }}">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer"
                                    onclick="openModal('concept-map-{{ $map->id }}')">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $map->title }}</p>
                                        <p class="text-xs text-gray-600">
                                            {{ count(is_array($map->nodes) ? $map->nodes : json_decode($map->nodes, true) ?? []) }}
                                            konsep</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="text-xs text-gray-500">{{ count(is_array($map->edges) ? $map->edges : json_decode($map->edges, true) ?? []) }}
                                            koneksi</span>
                                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        @if ($course->conceptMaps->count() > 5)
                            <p class="text-xs text-gray-500 text-center mt-2">+{{ $course->conceptMaps->count() - 5 }}
                                peta lainnya</p>
                        @endif
                    </div>
                    <button onclick="openModal('all-concept-maps')"
                        class="w-full mt-4 text-sm text-yellow-600 hover:text-yellow-800 font-medium">
                        <i class="fas fa-list mr-1"></i> Lihat Semua Peta Konsep
                    </button>
                @else
                    <p class="text-sm text-gray-500 text-center py-4">Belum ada peta konsep</p>
                @endif
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card card-hover">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-history mr-3 text-blue-600"></i>
                    Aktivitas Terbaru
                </h3>
            </div>
            <div class="p-6">
                @if ($recentActivities->isNotEmpty())
                    <div class="space-y-4 max-h-80 overflow-y-auto">
                        @foreach ($recentActivities as $activity)
                            <div
                                class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas {{ $activity['icon'] ?? 'fa-bolt' }} text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $activity['description'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="text-xs text-gray-400">{{ $activity['time_diff'] ?? '' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-gray-400 text-3xl mb-3"></i>
                        <p class="text-gray-500">Belum ada aktivitas terbaru</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div
            class="flex justify-between items-center p-6 bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl border border-gray-200">
            <div>
                <p class="text-sm text-gray-600">Terakhir diperbarui: {{ $course->updated_at->diffForHumans() }}</p>
            </div>
            <div class="flex space-x-3">
                <form action="{{ route('courses.destroy', $course) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini? Semua data terkait akan ikut terhapus.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="btn-secondary bg-red-50 text-red-600 hover:bg-red-100 border-red-200">
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

    <!-- Modals for Detail Views -->
    @include('courses.partials.modals')

    <style>
        /* Card hover animation */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Modal styles */
        .modal-backdrop {
            backdrop-filter: blur(5px);
        }

        .modal-content {
            max-height: 90vh;
            overflow-y: auto;
        }

        /* Status badge enhancement */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        /* Progress bar animation */
        .bg-gradient-to-r {
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Icon animation */
        .group:hover .fa-calendar-week,
        .group:hover .fa-chart-line,
        .group:hover .fa-book-open,
        .group:hover .fa-project-diagram,
        .group:hover .fa-history {
            animation: pulse 1s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Scrollbar styling */
        .max-h-64,
        .max-h-80 {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        .max-h-64::-webkit-scrollbar,
        .max-h-80::-webkit-scrollbar {
            width: 6px;
        }

        .max-h-64::-webkit-scrollbar-track,
        .max-h-80::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .max-h-64::-webkit-scrollbar-thumb,
        .max-h-80::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
    </style>

    <script>
        // Modal functions
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        // Close modal when clicking backdrop
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-backdrop')) {
                const modalId = e.target.getAttribute('data-modal-id');
                if (modalId) {
                    closeModal(modalId);
                }
            }
        });

        // ESC key to close modals
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('.modal:not(.hidden)');
                modals.forEach(modal => {
                    modal.classList.add('hidden');
                });
                document.body.style.overflow = 'auto';
            }
        });

        // Add smooth animations to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s both`;
            });
        });
    </script>
</x-app-layout>
