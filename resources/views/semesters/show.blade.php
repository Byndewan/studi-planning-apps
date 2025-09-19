<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $semester->name }}</h1>
            <p class="text-gray-600 mt-1 text-base">{{ $semester->start_date->format('d M Y') }} - {{ $semester->end_date->format('d M Y') }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('semesters.edit', $semester) }}" class="btn-secondary">
                <i class="fas fa-edit mr-2"></i>
                Edit
            </a>
            <form action="{{ route('semesters.generate-schedule', $semester) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-primary"
                    onclick="return confirm('Buat jadwal untuk semua mata kuliah? Ini akan membuat rencana mingguan untuk minggu 1-14.')">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Buat Jadwal
                </button>
            </form>
        </x-slot>
    </x-slot>

    <div class="space-y-8">
        <!-- Info Semester -->
        <div class="card card-hover">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="group">
                        <p class="text-sm font-medium text-gray-600">Periode</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1 group-hover:text-blue-600 transition-colors">
                            {{ $semester->start_date->format('d M Y') }} - {{ $semester->end_date->format('d M Y') }}
                        </p>
                    </div>
                    <div class="group">
                        <p class="text-sm font-medium text-gray-600">Total Mata Kuliah</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1 group-hover:text-green-600 transition-colors">{{ $semester->courses->count() }}</p>
                    </div>
                    <div class="group">
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <span class="status-badge {{ $semester->is_current ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $semester->is_current ? 'Semester Aktif' : 'Semester Lalu' }}
                        </span>
                    </div>
                </div>

                @if($semester->notes)
                    <div class="mt-6">
                        <p class="text-sm font-medium text-gray-600">Catatan</p>
                        <p class="text-gray-900 mt-2">{{ $semester->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Section Mata Kuliah -->
        <div class="card card-hover">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-book mr-2 text-blue-600"></i>
                        Mata Kuliah
                    </h2>
                    <a href="{{ route('courses.create') }}?semester_id={{ $semester->id }}" class="btn-primary text-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Mata Kuliah
                    </a>
                </div>
            </div>

            @if($semester->courses->isEmpty())
                <div class="empty-state py-16">
                    <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada mata kuliah</h3>
                    <p class="text-gray-600 mt-2">Tambahkan mata kuliah ke semester ini untuk memulai.</p>
                    <a href="{{ route('courses.create') }}?semester_id={{ $semester->id }}" class="btn-primary mt-6">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Mata Kuliah
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Mata Kuliah
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    SKS
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Modul
                                </th>
                                <th class="relative px-6 py-4">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($semester->courses as $course)
                                <tr class="hover:bg-gray-50 transition-all duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $course->code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $course->name }}</div>
                                        @if($course->notes)
                                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($course->notes, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $course->sks }} SKS</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $course->total_modules }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('courses.show', $course) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                                <i class="fas fa-eye mr-1"></i>
                                                Detail
                                            </a>
                                            <a href="{{ route('courses.edit', $course) }}"
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
            @endif
        </div>

        <!-- Ringkasan Performa -->
        @if($semester->courses->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total SKS</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $semester->courses->sum('sks') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fas fa-coins text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Modul</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $semester->courses->sum('total_modules') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-green-50 to-green-100 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fas fa-layer-group text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Rata-rata SKS</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $semester->courses->count() > 0 ? round($semester->courses->sum('sks') / $semester->courses->count(), 1) : 0 }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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

        /* Table row animation */
        tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        tr:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Icon animation */
        .group:hover .fa-book,
        .group:hover .fa-coins,
        .group:hover .fa-layer-group,
        .group:hover .fa-chart-bar {
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
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
</x-app-layout>
