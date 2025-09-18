<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Peta Konsep - {{ $conceptMap->title }}</h1>
            <p class="text-gray-600 mt-1">{{ $conceptMap->course->name }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('concept-maps.edit', $conceptMap) }}" class="btn-secondary">
                <i class="fas fa-edit mr-2"></i>
                Edit
            </a>
            <a href="{{ route('courses.show', $conceptMap->course) }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Mata Kuliah
            </a>
        </x-slot>
    </x-slot>

    @php
        // Pastikan nodes dan edges adalah array yang valid
        $nodes = [];
        $edges = [];

        if ($conceptMap->nodes) {
            try {
                $decodedNodes = is_string($conceptMap->nodes)
                    ? json_decode($conceptMap->nodes, true)
                    : $conceptMap->nodes;

                $nodes = is_array($decodedNodes) ? $decodedNodes : [];
            } catch (Exception $e) {
                $nodes = [];
            }
        }

        if ($conceptMap->edges) {
            try {
                $decodedEdges = is_string($conceptMap->edges)
                    ? json_decode($conceptMap->edges, true)
                    : $conceptMap->edges;

                $edges = is_array($decodedEdges) ? $decodedEdges : [];
            } catch (Exception $e) {
                $edges = [];
            }
        }
    @endphp

    <div id="vue-app" class="space-y-8">
        <!-- Info Peta Konsep -->
        <div class="card card-hover">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="group">
                        <p class="text-sm font-medium text-gray-600">Mata Kuliah</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1 group-hover:text-blue-600 transition-colors">{{ $conceptMap->course->name }}</p>
                    </div>
                    <div class="group">
                        <p class="text-sm font-medium text-gray-600">Konsep</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1 group-hover:text-green-600 transition-colors">{{ count($nodes) }}</p>
                    </div>
                    <div class="group">
                        <p class="text-sm font-medium text-gray-600">Koneksi</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1 group-hover:text-purple-600 transition-colors">{{ count($edges) }}</p>
                    </div>
                    <div class="group">
                        <p class="text-sm font-medium text-gray-600">Sumber</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1 group-hover:text-yellow-600 transition-colors">
                            @if ($conceptMap->sq3r_session_id)
                                SQ3R: {{ $conceptMap->sq3rSession->module_title ?? 'Modul Tidak Diketahui' }}
                            @else
                                Pembuatan Manual
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @if (count($nodes) === 0)
            <div class="card card-hover bg-yellow-50 border-yellow-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-3 text-xl"></i>
                        <h3 class="text-lg font-medium text-yellow-800">Belum ada konsep yang ditemukan</h3>
                    </div>
                    <p class="mt-2 text-yellow-700">
                        Peta konsep ini belum memiliki konsep apa pun. Klik "Tambah Konsep" untuk memulai!
                    </p>
                </div>
            </div>
        @endif

        <!-- Peta Konsep Interaktif -->
        <div class="card card-hover">
            <div class="p-6">
                <concept-map :nodes='@json($nodes)' :edges='@json($edges)'
                    :title='"{{ $conceptMap->title }}"'
                    autosave-url="{{ route('concept-maps.update', $conceptMap) }}" />
            </div>
        </div>

        <!-- Daftar Konsep -->
        @if (count($nodes) > 0)
            <div class="card card-hover">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-list-ul mr-2 text-blue-600"></i>
                        Ikhtisar Konsep
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                        @foreach ($nodes as $node)
                            @php
                                $label = $node['data']['label'] ?? 'Tidak Diketahui';
                                $category = $node['data']['category'] ?? 'detail';
                                $frequency = $node['data']['frequency'] ?? 0;
                                $color = $node['style']['background'] ?? '#96CEB4';
                            @endphp
                            <div class="concept-item group" style="border-left: 4px solid {{ $color }};">
                                <div class="font-medium text-gray-900 group-hover:text-gray-700 transition-colors">{{ $label }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ ucfirst(str_replace('_', ' ', $category)) }}
                                    @if ($frequency > 1)
                                        • {{ $frequency }} kali disebut
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Aksi -->
        <div class="card card-hover">
            <div class="p-6 flex justify-between items-center">
                <div class="group">
                    <p class="text-sm text-gray-600">
                        Terakhir diperbarui: <span class="group-hover:text-blue-600 transition-colors">{{ $conceptMap->updated_at->diffForHumans() }}</span>
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('concept-maps.edit', $conceptMap) }}" class="btn-primary">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Detail
                    </a>
                    <form action="{{ route('concept-maps.destroy', $conceptMap) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus peta konsep ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700 text-white">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus Peta
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .concept-item {
            @apply bg-gray-50 px-3 py-2 rounded-lg border border-gray-200 transition-all duration-200;
        }

        .concept-item:hover {
            @apply bg-gray-100 shadow-sm transform -translate-y-1;
        }

        /* Card hover animation */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Icon animation */
        .group:hover .fa-list-ul {
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
    </style>
</x-app-layout>
