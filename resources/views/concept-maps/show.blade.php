<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Concept Map - {{ $conceptMap->title }}
        </h2>
        <div class="header-actions space-x-2">
            <a href="{{ route('concept-maps.edit', $conceptMap) }}" class="btn-secondary">
                Edit
            </a>
            <a href="{{ route('courses.show', $conceptMap->course) }}" class="btn-secondary">
                Back to Course
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Concept Map Info -->
            <div class="card mb-6">
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Course</h4>
                            <p class="text-lg text-gray-900">{{ $conceptMap->course->name }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Nodes</h4>
                            <p class="text-lg text-gray-900">{{ $conceptMap->nodes ? count(json_decode($conceptMap->nodes, true)) : 0 }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Connections</h4>
                            <p class="text-lg text-gray-900">{{ $conceptMap->edges ? count(json_decode($conceptMap->edges, true)) : 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Concept Map Canvas -->
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Concept Map</h3>
                    <div class="flex space-x-2">
                        <button class="btn-secondary text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Auto Layout
                        </button>
                        <button class="btn-secondary text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Save
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Concept Map Container -->
                    <div class="bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 aspect-video relative overflow-hidden">
                        <!-- This is where the Vue.js concept map component would be rendered -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Concept map visualization would be displayed here</p>
                                <p class="text-xs text-gray-400">(Vue.js component integration required)</p>
                            </div>
                        </div>

                        <!-- Sample Nodes (for demonstration) -->
                        @if($conceptMap->nodes && count(json_decode($conceptMap->nodes, true)) > 0)
                            @foreach(json_decode($conceptMap->nodes, true) as $node)
                                <div class="absolute bg-white border border-gray-300 rounded p-3 shadow-sm cursor-move min-w-32"
                                     style="left: {{ $node['position']['x'] }}px; top: {{ $node['position']['y'] }}px;">
                                    <div class="font-medium text-sm text-center">{{ $node['data']['label'] }}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Legend -->
                    <div class="mt-4 flex flex-wrap gap-4 text-xs text-gray-600">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-200 rounded-full mr-1"></div>
                            <span>Main Concept</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-200 rounded-full mr-1"></div>
                            <span>Sub Concept</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-200 rounded-full mr-1"></div>
                            <span>Example</span>
                        </div>
                    </div>

                    <!-- Node List -->
                    @if($conceptMap->nodes && count(json_decode($conceptMap->nodes, true)) > 0)
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500 mb-3">Nodes List</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                @foreach(json_decode($conceptMap->nodes, true) as $node)
                                    <div class="bg-gray-50 px-3 py-2 rounded text-sm">
                                        {{ $node['data']['label'] }}
                                        @if(isset($node['data']['frequency']))
                                            <span class="text-xs text-gray-400 ml-1">({{ $node['data']['frequency'] }})</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-6 border-t pt-6 flex justify-end space-x-3">
                        <a href="{{ route('concept-maps.edit', $conceptMap) }}" class="btn-secondary">
                            Edit Map
                        </a>
                        <form action="{{ route('concept-maps.destroy', $conceptMap) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this concept map?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
