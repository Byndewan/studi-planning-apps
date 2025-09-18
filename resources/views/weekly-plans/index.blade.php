<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Rencana Mingguan</h1>
                <p class="text-gray-600 mt-1">Kelola jadwal dan target belajar mingguan Anda</p>
            </div>
            <x-slot name="headerActions">
                <a href="{{ route('weekly-plans.create') }}" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Rencana Baru
                </a>
            </x-slot>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Filters -->
        <div class="card card-hover">
            <div class="p-6">
                <form class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="group">
                        <label class="form-label">Semester</label>
                        <div class="relative">
                            <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <select class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">Semua Semester</option>
                                @foreach (auth()->user()->semesters as $semester)
                                    <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="group">
                        <label class="form-label">Mata Kuliah</label>
                        <div class="relative">
                            <i class="fas fa-book absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <select class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">Semua Mata Kuliah</option>
                                @foreach (auth()->user()->courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="group">
                        <label class="form-label">Status</label>
                        <div class="relative">
                            <i class="fas fa-filter absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <select class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">Semua Status</option>
                                <option value="planned">Direncanakan</option>
                                <option value="in_progress">Sedang Berlangsung</option>
                                <option value="completed">Selesai</option>
                                <option value="missed">Terlewat</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Weekly Plans -->
        @if ($weeklyPlans->isEmpty())
            <div class="card card-hover">
                <div class="empty-state py-16">
                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <i class="fas fa-calendar-week text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada rencana mingguan</h3>
                    <p class="text-gray-600 mb-6">Rencana mingguan akan dibuat saat Anda membuat jadwal untuk mata kuliah Anda.</p>
                    <a href="{{ route('weekly-plans.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Rencana Baru
                    </a>
                </div>
            </div>
        @else
            <div class="card card-hover overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Semester
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Mata Kuliah
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Minggu
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Target
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jam
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="relative px-6 py-4">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($weeklyPlans as $plan)
                                <tr class="hover:bg-gray-50 transition-all duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $plan->course->semester->name }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $plan->course->name }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $plan->course->code }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            Minggu {{ $plan->week_number }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ Str::limit($plan->target_text, 40) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $plan->planned_hours }} jam
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="status-badge status-{{ $plan->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $plan->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('weekly-plans.show', $plan) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                                <i class="fas fa-eye mr-1"></i>
                                                Lihat
                                            </a>
                                            <a href="{{ route('weekly-plans.edit', $plan) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-all duration-200">
                                                <i class="fas fa-edit mr-1"></i>
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if ($weeklyPlans->hasPages())
                <div class="mt-6">
                    {{ $weeklyPlans->links() }}
                </div>
            @endif
        @endif
    </div>

    <style>
        /* Table row animation */
        tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        tr:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Status badge animation */
        .status-badge {
            transition: all 0.2s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        /* Action buttons animation */
        .text-blue-600, .text-gray-600 {
            transition: all 0.2s ease;
        }

        .text-blue-600:hover, .text-gray-600:hover {
            transform: translateY(-1px);
        }

        /* Empty state animation */
        .empty-state {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        // Add smooth transitions to all interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on load
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s both`;
            });

            // Add hover effects to buttons
            const buttons = document.querySelectorAll('button, .btn-primary, .btn-secondary');
            buttons.forEach(button => {
                button.classList.add('interactive');
            });
        });
    </script>
</x-app-layout>
