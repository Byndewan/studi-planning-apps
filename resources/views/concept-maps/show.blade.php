<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Concept Map - {{ $conceptMap->title }}</h1>
            <p class="text-gray-600 mt-1">{{ $conceptMap->course->name }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('concept-maps.edit', $conceptMap) }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Edit
            </a>
            <a href="{{ route('courses.show', $conceptMap->course) }}" class="btn-secondary">
                Back to Course
            </a>
        </x-slot>
    </x-slot>

    @php
        $nodes = is_array($conceptMap->nodes) ? $conceptMap->nodes : json_decode($conceptMap->nodes, true) ?? [];

        $edges = is_array($conceptMap->edges) ? $conceptMap->edges : json_decode($conceptMap->edges, true) ?? [];
    @endphp

    <div class="space-y-6">
        <!-- Concept Map Info -->
        <div class="card">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Course</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $conceptMap->course->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Nodes</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ count($nodes) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Connections</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ count($edges) }}</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Concept Map Canvas -->
        <div class="card">
            <concept-map :nodes='@json($nodes)' :edges='@json($edges)'></concept-map>
            {{-- <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Concept Map</h2>
                    <div class="flex space-x-2">
                        <button class="btn-secondary text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Auto Layout
                        </button>
                        <button class="btn-secondary text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Save
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Concept Map Container -->
                <div
                    class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 aspect-video relative overflow-hidden">


                    <!-- This is where the Vue.js concept map component would be rendered -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-white rounded-xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                                <x-icons.map class="w-8 h-8 text-gray-400" />
                            </div>
                            <p class="text-sm text-gray-600">Concept map visualization would be displayed here</p>
                            <p class="text-xs text-gray-400 mt-1">(Vue.js component integration required)</p>
                        </div>
                    </div>

                    <!-- Sample Nodes (for demonstration) -->
                    @if (count($nodes) > 0)
                        @foreach ($nodes as $node)
                            @php
                                $posX = isset($node['position']['x']) ? $node['position']['x'] : 0;
                                $posY = isset($node['position']['y']) ? $node['position']['y'] : 0;
                                $label = $node['data']['label'] ?? 'No Label';
                                $freq = $node['data']['frequency'] ?? null;
                            @endphp

                            <div class="absolute bg-white border border-gray-200 rounded-lg p-3 shadow-sm cursor-move min-w-32 hover:shadow-md transition-shadow"
                                style="left: {{ $posX }}px; top: {{ $posY }}px;">
                                <div class="font-medium text-sm text-center">{{ $label }}</div>
                                @if ($freq)
                                    <div class="text-xs text-gray-500 text-center mt-1">Freq: {{ $freq }}</div>
                                @endif
                            </div>
                        @endforeach
                    @endif

                </div>

                <!-- Legend -->
                <div class="mt-6 flex flex-wrap gap-4 text-sm">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-200 rounded-full mr-2"></div>
                        <span class="text-gray-600">Main Concept</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-200 rounded-full mr-2"></div>
                        <span class="text-gray-600">Sub Concept</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-200 rounded-full mr-2"></div>
                        <span class="text-gray-600">Example</span>
                    </div>
                </div>

                <!-- Node List -->
                @if (count($nodes) > 0)
                    <div class="mt-8">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Concepts</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @foreach ($nodes as $node)
                                @php
                                    $label = isset($node['data']['label']) ? $node['data']['label'] : 'No Label';
                                    $freq = isset($node['data']['frequency']) ? $node['data']['frequency'] : null;
                                @endphp

                                <div class="bg-gray-50 px-4 py-3 rounded-lg text-sm border border-gray-200">
                                    <div class="font-medium text-gray-900">{{ $label }}</div>
                                    @if ($freq)
                                        <div class="text-xs text-gray-500 mt-1">Appears {{ $freq }} times</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="mt-8 border-t border-gray-200 pt-6 flex justify-end space-x-3">
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
        </div> --}}
    </div>
</x-app-layout>
