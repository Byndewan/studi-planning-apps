<!-- Modal Backdrop -->

<div id="all-weekly-plans" class="modal hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="modal-backdrop fixed inset-0 bg-black bg-opacity-50" data-modal-id="all-weekly-plans"></div>
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="modal-content bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-900">Semua Rencana Mingguan</h3>
                    <button onclick="closeModal('all-weekly-plans')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Minggu</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Target</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jam</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($course->weeklyPlans as $plan)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Minggu {{ $plan->week_number }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ \Illuminate\Support\Str::limit($plan->target_text, 50) }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="space-y-3 max-h-64 overflow-y-auto">
                                            @if ($recentActivities->isNotEmpty())
                                                @foreach ($recentActivities as $activity)
                                                    <div
                                                        class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                                        <div
                                                            class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                            <i class="fas fa-bolt text-blue-600 text-sm"></i>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-gray-900">
                                                                {{ $activity['description'] }}</p>
                                                            <p class="text-xs text-gray-500">{{ $activity['time'] }}
                                                            </p>
                                                        </div>
                                                        <i class="fas fa-clock text-gray-400 text-xs"></i>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="text-center py-4 text-gray-500">Belum ada aktivitas
                                                    terbaru
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $plan->status ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="#" class="text-blue-600 hover:underline">Lihat</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8">
                                        <i class="fas fa-inbox text-gray-400 text-3xl mb-3"></i>
                                        <p class="text-gray-500">Belum ada rencana mingguan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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

    <!-- Modals for Detail Views -->
    <div id="modal-backdrop" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40" onclick="closeModal()"></div>

    <!-- Modal for Recent Activities -->
    <div id="recent-activities-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                    <div id="recent-activities-content">
                        <!-- Content loaded -->
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
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.05);
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

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
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

        /* Modal styles */
        #modal-backdrop {
            backdrop-filter: blur(4px);
        }

        .max-h-\[calc\(90vh-120px\)\] {
            max-height: calc(90vh - 120px);
        }

        /* Scrollbar styling for modals */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Status badge enhancement */
        .status-badge {
            transition: all 0.2s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        /* Cursor pointer for clickable items */
        .cursor-pointer {
            cursor: pointer;
        }
    </style>

    <script>
        // Modal functions
        function openModal(modalId) {
            document.getElementById('modal-backdrop').classList.remove('hidden');
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('modal-backdrop').classList.add('hidden');
            document.querySelectorAll('[id$="-modal"]').forEach(modal => {
                modal.classList.add('hidden');
            });
            document.body.style.overflow = 'auto';
        }

        // Load modal content based on type
        function loadModalContent(type, id) {
            // This would be implemented with actual AJAX calls to fetch detailed data
            // For now, we'll show placeholder content
            const content = document.getElementById('recent-activities-content');

            switch (type) {
                case 'monitoring':
                    content.innerHTML = '<p class="text-center py-4">Loading monitoring details...</p>';
                    break;
                case 'sq3r':
                    content.innerHTML = '<p class="text-center py-4">Loading SQ3R session details...</p>';
                    break;
                case 'concept-maps':
                    content.innerHTML = '<p class="text-center py-4">Loading concept map details...</p>';
                    break;
                default:
                    loadRecentActivities();
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth animations to cards
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

            // Add click handlers for modal triggers
            document.querySelectorAll('[onclick^="openModal"]').forEach(element => {
                element.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });

            // Close modal on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        });
    </script>
