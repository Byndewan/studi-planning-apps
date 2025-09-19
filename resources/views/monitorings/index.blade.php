<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Monitoring Belajar</h1>
            <p class="text-gray-600 mt-1 text-base">Pantau kemajuan dan evaluasi belajar Anda</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('monitorings.create') }}" class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Catat Sesi Baru
            </a>
        </x-slot>
    </x-slot>

    <div class="space-y-8">
        <!-- Filter -->
        <div class="card card-hover">
            <div class="p-6">
                <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="group">
                        <label class="form-label">Mata Kuliah</label>
                        <div class="relative">
                            <i
                                class="fas fa-book absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <select id="filter-course"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">Semua Mata Kuliah</option>
                                @foreach (auth()->user()->courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="group">
                        <label class="form-label">Status Pencapaian</label>
                        <div class="relative">
                            <i
                                class="fas fa-trophy absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <select id="filter-status"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">Semua Status</option>
                                <option value="1">Tercapai</option>
                                <option value="0">Tidak Tercapai</option>
                            </select>
                        </div>
                    </div>
                    <div class="group">
                        <label class="form-label">Dari Tanggal</label>
                        <div class="relative">
                            <i
                                class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <input id="filter-start" type="date"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>
                    </div>
                    <div class="group">
                        <label class="form-label">Sampai Tanggal</label>
                        <div class="relative">
                            <i
                                class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <input id="filter-end" type="date"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Ringkasan Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Sesi</p>
                            <p
                                class="text-2xl font-bold text-gray-900 mt-1 group-hover:text-blue-600 transition-colors">
                                {{ $monitorings->total() }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Tercapai</p>
                            <p
                                class="text-2xl font-bold text-gray-900 mt-1 group-hover:text-green-600 transition-colors">
                                {{ $monitorings->where('achieved', true)->count() }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-50 to-green-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Tidak Tercapai</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1 group-hover:text-red-600 transition-colors">
                                {{ $monitorings->where('achieved', false)->count() }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-red-50 to-red-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-hover group">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Persentase Sukses</p>
                            <p
                                class="text-2xl font-bold text-gray-900 mt-1 group-hover:text-purple-600 transition-colors">
                                {{ $monitorings->count() > 0 ? round(($monitorings->where('achieved', true)->count() / $monitorings->count()) * 100) : 0 }}%
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                            <i class="fas fa-percentage text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Monitoring -->
        @if ($monitorings->isEmpty())
            <div class="card card-hover">
                <div class="empty-state py-16">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <i class="fas fa-chart-bar text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada data monitoring</h3>
                    <p class="text-gray-600 mb-6">Mulai pantau kemajuan belajar Anda dengan mencatat sesi pertama</p>
                    <a href="{{ route('monitorings.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Catat Sesi Baru
                    </a>
                </div>
            </div>
        @else
            <div class="card card-hover overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Minggu
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Mata Kuliah
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Target
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="relative px-6 py-4">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="monitoring-container" class="bg-white divide-y divide-gray-200">
                            @foreach ($monitorings as $monitoring)
                                <tr class="hover:bg-gray-50 transition-all duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $monitoring->date->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Minggu {{ $monitoring->week_number }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $monitoring->course->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $monitoring->course->semester->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ Str::limit($monitoring->planned, 50) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="status-badge {{ $monitoring->achieved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $monitoring->achieved ? 'Tercapai' : 'Tidak Tercapai' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('monitorings.show', $monitoring) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                                <i class="fas fa-eye mr-1"></i>
                                                Detail
                                            </a>
                                            <a href="{{ route('monitorings.edit', $monitoring) }}"
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
            @if ($monitorings->hasPages())
                <div class="mt-6">
                    {{ $monitorings->links() }}
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
        .text-blue-600,
        .text-gray-600 {
            transition: all 0.2s ease;
        }

        .text-blue-600:hover,
        .text-gray-600:hover {
            transform: translateY(-1px);
        }

        /* Card hover animation */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Icon animation */
        .group:hover .fa-chart-line,
        .group:hover .fa-check-circle,
        .group:hover .fa-times-circle,
        .group:hover .fa-percentage {
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
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const course = document.getElementById("filter-course");
            const status = document.getElementById("filter-status");
            const start = document.getElementById("filter-start");
            const end = document.getElementById("filter-end");

            function fetchData() {
                fetch("{{ route('tasks.filter.monitoring') }}?course=" + course.value +
                        "&status=" + status.value +
                        "&start=" + start.value +
                        "&end=" + end.value)
                    .then(res => res.json())
                    .then(data => {
                        const container = document.getElementById("monitoring-container");
                        container.innerHTML = "";

                        if (data.length === 0) {
                            container.innerHTML =
                                `<tr><td colspan="6" class="text-center text-gray-500 py-4">Tidak ada data</td></tr>`;
                        } else {
                            data.forEach(monitoring => {
                                container.innerHTML += `
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">${monitoring.date}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Minggu ${monitoring.week_number}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">${monitoring.course?.name ?? '-'}</div>
                                    <div class="text-xs text-gray-500">${monitoring.course?.semester?.name ?? '-'}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">${monitoring.planned}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="${monitoring.achieved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} px-2 py-1 rounded-full text-xs">
                                        ${monitoring.achieved ? 'Tercapai' : 'Tidak Tercapai'}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <a href="/monitorings/${monitoring.id}" class="text-blue-600 hover:text-blue-800">Detail</a>
                                </td>
                            </tr>
                        `;
                            });
                        }
                    })
                    .catch(err => console.error(err));
            }

            [course, status, start, end].forEach(el => {
                el.addEventListener("change", fetchData);
            });

            fetchData();
        });
    </script>

</x-app-layout>
