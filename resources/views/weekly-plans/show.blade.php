<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $weeklyPlan->course->name }} - Minggu {{ $weeklyPlan->week_number }}</h1>
                <p class="text-gray-600 mt-1">{{ $weeklyPlan->course->semester->name }}</p>
            </div>
            <x-slot name="headerActions">
                <a href="{{ route('weekly-plans.edit', $weeklyPlan) }}" class="btn-primary">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Rencana
                </a>
                <a href="{{ route('courses.show', $weeklyPlan->course) }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Mata Kuliah
                </a>
            </x-slot>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Plan Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Minggu</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors">#{{ $weeklyPlan->week_number }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-calendar-week text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Jam Rencana</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $weeklyPlan->planned_hours }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-clock text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Halaman</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">{{ $weeklyPlan->num_pages }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-green-50 to-green-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-file-alt text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Status</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">{{ ucfirst(str_replace('_', ' ', $weeklyPlan->status)) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-play-circle text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Details -->
        <div class="card card-hover">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-target mr-3 text-blue-600"></i>
                    Target Mingguan
                </h3>
            </div>
            <div class="card-body">
                <p class="text-gray-900 leading-relaxed">{{ $weeklyPlan->target_text }}</p>
            </div>
        </div>

        <!-- Plan Statistics -->
        <div class="card card-hover">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-chart-bar mr-3 text-green-600"></i>
                    Statistik Rencana
                </h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Jam Rencana:</span>
                            <span class="font-semibold text-gray-900">{{ $weeklyPlan->planned_hours }} jam</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Halaman:</span>
                            <span class="font-semibold text-gray-900">{{ $weeklyPlan->num_pages }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Media:</span>
                            <span class="font-semibold text-gray-900">
                                {{ count(is_array($weeklyPlan->media) ? $weeklyPlan->media : json_decode($weeklyPlan->media, true) ?? []) }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Diperbarui:</span>
                            <span class="font-semibold text-gray-900">{{ $weeklyPlan->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="card card-hover">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-tasks mr-3 text-purple-600"></i>
                    Progress Mingguan
                </h3>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Progress</span>
                        <span class="font-medium text-gray-900">
                            @php
                                $progress = $weeklyPlan->status === 'completed' ? 100 :
                                           ($weeklyPlan->status === 'in_progress' ? 50 : 0);
                            @endphp
                            {{ $progress }}%
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Mulai</span>
                        <span>Selesai</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center p-6 bg-gradient-to-r from-gray-50 to-purple-50 rounded-2xl border border-gray-200">
            <div>
                <p class="text-sm text-gray-600">Terakhir diperbarui: {{ $weeklyPlan->updated_at->diffForHumans() }}</p>
            </div>
            <div class="flex space-x-3">
                <form action="{{ route('weekly-plans.destroy', $weeklyPlan) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus rencana mingguan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary bg-red-50 text-red-600 hover:bg-red-100 border-red-200">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus
                    </button>
                </form>
                <a href="{{ route('weekly-plans.edit', $weeklyPlan) }}" class="btn-primary">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Rencana
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
        .group:hover .fa-calendar-week,
        .group:hover .fa-clock,
        .group:hover .fa-file-alt,
        .group:hover .fa-play-circle {
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

            // Animate progress bar on load
            setTimeout(() => {
                const progressFill = document.querySelector('.progress-fill');
                if (progressFill) {
                    progressFill.style.transition = 'width 1.5s cubic-bezier(0.4, 0, 0.2, 1)';
                }
            }, 300);
        });
    </script>
</x-app-layout>
