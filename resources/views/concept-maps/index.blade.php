F<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Concept Maps</h1>
            <p class="text-gray-600 mt-1">Visualize and organize your knowledge</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('concept-maps.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Map
            </a>
        </x-slot>
    </x-slot>

    <div class="space-y-6">
        <!-- Filters -->
        <div class="card">
            <div class="p-6">
                <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Course</label>
                        <select class="form-input">
                            <option value="">All Courses</option>
                            @foreach (auth()->user()->courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Title</label>
                        <input type="text" class="form-input" placeholder="Search by title">
                    </div>
                    <div>
                        <label class="form-label">Date Range</label>
                        <input type="text" class="form-input" placeholder="Select date range">
                    </div>
                </form>
            </div>
        </div>

        <!-- Concept Maps Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if ($conceptMaps->isEmpty())
                <div class="md:col-span-3 card">
                    <div class="empty-state">
                        <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <x-icons.map class="w-8 h-8 text-gray-400" />
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No concept maps yet</h3>
                        <p class="text-gray-600 mt-2">Visualize your knowledge by creating your first concept map.</p>
                        <a href="{{ route('concept-maps.create') }}" class="btn-primary mt-6">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Concept Map
                        </a>
                    </div>
                </div>
            @else
                @foreach ($conceptMaps as $map)
                    <div class="card hover:shadow-lg transition-shadow">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $map->title }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $map->course->name }}</p>
                        </div>

                        <div class="p-6">
                            <!-- Map Preview -->
                            <div class="aspect-video bg-gray-100 rounded-lg mb-4 flex items-center justify-center">
                                <x-icons.map class="w-12 h-12 text-gray-400" />
                            </div>

                            <!-- Stats -->
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 mb-4">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 10H2v2a3 3 0 005.356 1.857M7 10v4a2 2 0 01-2 2H3m0-10a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                    @php
                                        $nodes = is_array($map->nodes)
                                            ? $map->nodes
                                            : json_decode($map->nodes, true) ?? [];
                                    @endphp

                                    <span>{{ count($nodes) }} nodes</span>

                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    @php
                                        $edges = is_array($map->edges)
                                            ? $map->edges
                                            : json_decode($map->edges, true) ?? [];
                                    @endphp

                                    <span>{{ count($edges) }} connections</span>
                                </div>
                            </div>

                            <!-- Last Updated -->
                            <p class="text-xs text-gray-500 mb-4">
                                Last updated {{ $map->updated_at->diffForHumans() }}
                            </p>

                            <div class="flex space-x-2">
                                <a href="{{ route('concept-maps.show', $map) }}"
                                    class="btn-secondary flex-1 text-center">
                                    View Map
                                </a>
                                <a href="{{ route('concept-maps.edit', $map) }}" class="btn-secondary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
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
</x-app-layout>
