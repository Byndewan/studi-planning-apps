<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Concept Maps') }}
        </h2>
        <div class="header-actions">
            <a href="{{ route('concept-maps.create') }}" class="btn-primary">
                {{ __('New Concept Map') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="card mb-6">
                <div class="card-body">
                    <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="form-label">Course</label>
                            <select class="form-input">
                                <option value="">All Courses</option>
                                @foreach(auth()->user()->courses as $course)
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
                @if($conceptMaps->isEmpty())
                    <div class="md:col-span-3 card text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No concept maps yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Visualize your knowledge by creating your first concept map.</p>
                        <div class="mt-6">
                            <a href="{{ route('concept-maps.create') }}" class="btn-primary">
                                {{ __('New Concept Map') }}
                            </a>
                        </div>
                    </div>
                @else
                    @foreach($conceptMaps as $map)
                        <div class="card hover:shadow-lg transition-shadow duration-200">
                            <div class="card-header">
                                <h3 class="text-lg font-medium text-gray-900">{{ $map->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $map->course->name }}</p>
                            </div>

                            <div class="card-body">
                                <!-- Map Preview -->
                                <div class="aspect-video bg-gray-100 rounded mb-4 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>

                                <!-- Stats -->
                                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 mb-4">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span>{{ $map->nodes ? count(json_decode($map->nodes, true)) : 0 }} nodes</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <span>{{ $map->edges ? count(json_decode($map->edges, true)) : 0 }} connections</span>
                                    </div>
                                </div>

                                <!-- Last Updated -->
                                <p class="text-xs text-gray-500 mb-4">
                                    Last updated {{ $map->updated_at->diffForHumans() }}
                                </p>

                                <div class="flex space-x-2">
                                    <a href="{{ route('concept-maps.show', $map) }}" class="btn-secondary flex-1 text-center">
                                        View Map
                                    </a>
                                    <a href="{{ route('concept-maps.edit', $map) }}" class="btn-secondary">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Pagination -->
            @if($conceptMaps->isNotEmpty())
                <div class="mt-6">
                    {{ $conceptMaps->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
