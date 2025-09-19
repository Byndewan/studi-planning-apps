<div class="card card-hover hover:shadow-lg transition-all duration-300">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900">{{ $map->title }}</h3>
        <p class="text-sm text-gray-600 mt-1">{{ $map->course->name }}</p>
    </div>

    <div class="p-6">
        <div class="aspect-video bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg mb-4 flex items-center justify-center border border-gray-200">
            <i class="fas fa-project-diagram text-gray-400 text-4xl"></i>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 mb-4">
            <div class="flex items-center">
                <i class="fas fa-circle-nodes w-4 h-4 mr-2 text-blue-600"></i>
                @php
                    $nodes = is_array($map->nodes) ? $map->nodes : json_decode($map->nodes, true) ?? [];
                @endphp
                <span>{{ count($nodes) }} konsep</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-link w-4 h-4 mr-2 text-green-600"></i>
                @php
                    $edges = is_array($map->edges) ? $map->edges : json_decode($map->edges, true) ?? [];
                @endphp
                <span>{{ count($edges) }} koneksi</span>
            </div>
        </div>

        <p class="text-xs text-gray-500 mb-4">
            Terakhir diperbarui {{ $map->updated_at->diffForHumans() }}
        </p>

        <div class="flex space-x-2">
            <a href="{{ route('concept-maps.show', $map) }}" class="btn-secondary flex-1 text-center">
                <i class="fas fa-eye mr-2"></i> Lihat Peta
            </a>
            <a href="{{ route('concept-maps.edit', $map) }}" class="btn-secondary">
                <i class="fas fa-edit"></i>
            </a>
        </div>
    </div>
</div>
