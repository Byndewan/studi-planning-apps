<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">SQ3R Sessions</h1>
                <p class="text-gray-600 mt-1 text-base">Sesi membaca aktif menggunakan metode SQ3R</p>
            </div>
            <x-slot name="headerActions">
                <a href="{{ route('sq3r.create') }}" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Sesi Baru
                </a>
            </x-slot>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Filters -->
        <div class="card card-hover">
            <div class="p-6">
                <form class="grid grid-cols-1 md:grid-cols-3 gap-4" id="sq3r-filter">
                    <div>
                        <label class="form-label">Mata Kuliah</label>
                        <select id="filter-course" class="form-input">
                            <option value="">Semua Mata Kuliah</option>
                            @foreach (auth()->user()->courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Modul</label>
                        <input id="filter-module" type="text" class="form-input"
                            placeholder="Cari berdasarkan judul modul">
                    </div>
                    <div>
                        <label class="form-label">Rentang Tanggal</label>
                        <input id="filter-date" type="date" class="form-input" placeholder="Pilih rentang tanggal">
                    </div>
                </form>

            </div>
        </div>

        <!-- SQ3R Sessions -->
        @if ($sessions->isEmpty())
            <div class="card card-hover">
                <div class="empty-state py-16">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-purple-100 to-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <i class="fas fa-book-open text-purple-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada sesi SQ3R</h3>
                    <p class="text-gray-600 mb-6">Mulai perjalanan membaca aktif Anda dengan membuat sesi SQ3R pertama
                    </p>
                    <a href="{{ route('sq3r.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Sesi Baru
                    </a>
                </div>
            </div>
        @else
            <div id="sq3r-container" class="space-y-6">
                @foreach ($sessions as $session)
                    <div class="card card-hover sq3r-item" data-course="{{ $session->course_id }}"
                        data-module="{{ strtolower($session->module_title) }}">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-purple-50 to-blue-50 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                                        <i class="fas fa-book-open text-purple-600 text-lg"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                            {{ $session->module_title }}</h3>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            <span class="flex items-center">
                                                <i class="fas fa-book mr-1"></i>
                                                {{ $session->course->name }}
                                            </span>
                                            <span class="flex items-center">
                                                <i class="far fa-calendar mr-1"></i>
                                                {{ $session->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if ($session->review_notes)
                                        <span class="status-badge status-completed">
                                            <i class="fas fa-check mr-1"></i>
                                            Selesai
                                        </span>
                                    @else
                                        <span class="status-badge status-in-progress">
                                            <i class="fas fa-clock mr-1"></i>
                                            Dalam Proses
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Progress Steps -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                                    <span
                                        class="flex items-center {{ $session->survey_notes ? 'text-green-600' : 'text-gray-400' }}">
                                        <i class="fas fa-search mr-1"></i> Survey
                                    </span>
                                    <span
                                        class="flex items-center {{ $session->questions ? 'text-green-600' : 'text-gray-400' }}">
                                        <i class="fas fa-question mr-1"></i> Question
                                    </span>
                                    <span
                                        class="flex items-center {{ $session->read_notes ? 'text-green-600' : 'text-gray-400' }}">
                                        <i class="fas fa-book-reader mr-1"></i> Read
                                    </span>
                                    <span
                                        class="flex items-center {{ $session->recite_notes ? 'text-green-600' : 'text-gray-400' }}">
                                        <i class="fas fa-comment-alt mr-1"></i> Recite
                                    </span>
                                    <span
                                        class="flex items-center {{ $session->review_notes ? 'text-green-600' : 'text-gray-400' }}">
                                        <i class="fas fa-sync-alt mr-1"></i> Review
                                    </span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill"
                                        style="width: {{ $session->review_notes ? '100%' : ($session->recite_notes ? '80%' : ($session->read_notes ? '60%' : ($session->questions ? '40%' : ($session->survey_notes ? '20%' : '0%')))) }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Questions Preview -->
                            @php
                                $questions = is_array($session->questions)
                                    ? $session->questions
                                    : json_decode($session->questions, true) ?? [];
                            @endphp

                            @if (count($questions) > 0)
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-600 mb-2">Pertanyaan:</p>
                                    <div class="space-y-1">
                                        @foreach (array_slice($questions, 0, 3) as $question)
                                            <p class="text-sm text-gray-700">• {{ $question }}</p>
                                        @endforeach

                                        @if (count($questions) > 3)
                                            <p class="text-sm text-gray-500">
                                                +{{ count($questions) - 3 }} pertanyaan lainnya
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="flex justify-end">
                                <a href="{{ route('sq3r.show', $session) }}" class="btn-secondary">
                                    <i class="fas fa-play mr-2"></i>
                                    Lanjutkan Sesi
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                @if ($sessions->hasPages())
                    <div class="mt-8">
                        {{ $sessions->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>

    <style>
        /* Progress bar animation */
        .progress-bar {
            width: 100%;
            height: 6px;
            background: #f3f4f6;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #8b5cf6 0%, #3b82f6 100%);
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: progressShine 2s infinite;
        }

        @keyframes progressShine {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        /* Card hover animation */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Status badge animation */
        .status-badge {
            transition: all 0.2s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        /* Icon color transition */
        .text-green-600,
        .text-gray-400 {
            transition: color 0.3s ease;
        }
    </style>

    <script>
        // Add smooth animations to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s both`;
            });

            // Add hover effects to progress bars
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                bar.addEventListener('mouseenter', function() {
                    this.style.transform = 'scaleY(1.2)';
                });

                bar.addEventListener('mouseleave', function() {
                    this.style.transform = 'scaleY(1)';
                });
            });
        });

        // Filter functionality
        document.addEventListener("DOMContentLoaded", () => {
            const course = document.getElementById("filter-course");
            const module = document.getElementById("filter-module");
            const date = document.getElementById("filter-date");

            function fetchData() {
                fetch("{{ route('tasks.filter.sq3r') }}?course=" + course.value +
                        "&module=" + module.value +
                        "&date=" + date.value)
                    .then(res => res.json())
                    .then(data => {
                        const container = document.getElementById("sq3r-container");
                        container.innerHTML = "";

                        if (data.length === 0) {
                            container.innerHTML = `<p class="text-gray-500 card card-hover p-6">Tidak ada sesi ditemukan</p>`;
                        } else {
                            data.forEach(session => {
                                container.innerHTML += `
                            <div class="card card-hover">
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-6">
                                        <div class="flex items-start space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-purple-50 to-blue-50 rounded-xl flex items-center justify-center shadow-sm">
                                                <i class="fas fa-book-open text-purple-600 text-lg"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900 mb-1">${session.module_title}</h3>
                                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                    <span><i class="fas fa-book mr-1"></i> ${session.course?.name ?? '-'}</span>
                                                    <span><i class="far fa-calendar mr-1"></i> ${session.date}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            ${session.review_notes
                                                ? `<span class="status-badge status-completed"><i class="fas fa-check mr-1"></i> Selesai</span>`
                                                : `<span class="status-badge status-in-progress"><i class="fas fa-clock mr-1"></i> Dalam Proses</span>`}
                                        </div>
                                    </div>
                                    <div class="mb-6">
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: ${session.progress}%"></div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end">
                                        <a href="/sq3r/${session.id}" class="btn-secondary">
                                            <i class="fas fa-play mr-2"></i> Lanjutkan Sesi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                            });
                        }
                    })
                    .catch(err => console.error(err));
            }

            [course, module, date].forEach(el => {
                el.addEventListener("change", fetchData);
                el.addEventListener("keyup", fetchData);
            });

            fetchData();
        });
    </script>
</x-app-layout>
