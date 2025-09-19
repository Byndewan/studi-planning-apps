<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Peta Konsep</h1>
            <p class="text-gray-600 mt-1 text-base">Visualisasikan dan organisasikan pengetahuan Anda</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('concept-maps.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Peta Konsep Baru
            </a>
        </x-slot>
    </x-slot>

    <div class="space-y-6">
        <!-- Filter -->
        <div class="card card-hover">
            <div class="p-6">
                <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                        <label class="form-label">Judul</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <input type="text" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" placeholder="Cari berdasarkan judul">
                        </div>
                    </div>
                    <div class="group">
                        <label class="form-label">Rentang Tanggal</label>
                        <div class="relative">
                            <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <input type="text" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" placeholder="Pilih rentang tanggal">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Grid Peta Konsep -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if ($conceptMaps->isEmpty())
                <div class="md:col-span-3 card card-hover">
                    <div class="empty-state py-16">
                        <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                            <i class="fas fa-project-diagram text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada peta konsep</h3>
                        <p class="text-gray-600 mb-6">Visualisasikan pengetahuan Anda dengan membuat peta konsep pertama</p>
                        <a href="{{ route('concept-maps.create') }}" class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Peta Konsep Baru
                        </a>
                    </div>
                </div>
            @else
                @foreach ($conceptMaps as $map)
                    <div class="card card-hover hover:shadow-lg transition-all duration-300">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $map->title }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $map->course->name }}</p>
                        </div>

                        <div class="p-6">
                            <!-- Pratinjau Peta -->
                            <div class="aspect-video bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg mb-4 flex items-center justify-center border border-gray-200">
                                <i class="fas fa-project-diagram text-gray-400 text-4xl"></i>
                            </div>

                            <!-- Statistik -->
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-circle-nodes w-4 h-4 mr-2 text-blue-600"></i>
                                    @php
                                        $nodes = is_array($map->nodes)
                                            ? $map->nodes
                                            : json_decode($map->nodes, true) ?? [];
                                    @endphp
                                    <span>{{ count($nodes) }} konsep</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-link w-4 h-4 mr-2 text-green-600"></i>
                                    @php
                                        $edges = is_array($map->edges)
                                            ? $map->edges
                                            : json_decode($map->edges, true) ?? [];
                                    @endphp
                                    <span>{{ count($edges) }} koneksi</span>
                                </div>
                            </div>

                            <!-- Terakhir Diperbarui -->
                            <p class="text-xs text-gray-500 mb-4">
                                Terakhir diperbarui {{ $map->updated_at->diffForHumans() }}
                            </p>

                            <div class="flex space-x-2">
                                <a href="{{ route('concept-maps.show', $map) }}"
                                    class="btn-secondary flex-1 text-center">
                                    <i class="fas fa-eye mr-2"></i>
                                    Lihat Peta
                                </a>
                                <a href="{{ route('concept-maps.edit', $map) }}" class="btn-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Pagination -->
        @if ($conceptMaps->isNotEmpty())
            <div class="mt-6">
                {{ $conceptMaps->links() }}
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

        /* Icon animation */
        .fa-project-diagram {
            transition: all 0.3s ease;
        }

        .card-hover:hover .fa-project-diagram {
            transform: scale(1.1);
            color: #3b82f6;
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
</x-app-layout>
