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
        // Ensure we have proper arrays, not JSON strings
        $nodes = [];
        $edges = [];

        if ($conceptMap->nodes) {
            $nodes = is_string($conceptMap->nodes)
                ? json_decode($conceptMap->nodes, true)
                : (is_array($conceptMap->nodes)
                    ? $conceptMap->nodes
                    : []);
        }

        if ($conceptMap->edges) {
            $edges = is_string($conceptMap->edges)
                ? json_decode($conceptMap->edges, true)
                : (is_array($conceptMap->edges)
                    ? $conceptMap->edges
                    : []);
        }

        // Ensure we have valid arrays
        $nodes = is_array($nodes) ? $nodes : [];
        $edges = is_array($edges) ? $edges : [];
    @endphp

    <div id="vue-app" class="space-y-6">
        <!-- Concept Map Info -->
        <div class="card">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Course</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $conceptMap->course->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Concepts</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ count($nodes) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Connections</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ count($edges) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Source</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">
                            @if ($conceptMap->sq3r_session_id)
                                SQ3R: {{ $conceptMap->sq3rSession->module_title ?? 'Unknown Module' }}
                            @else
                                Manual Creation
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 🔥 **DEBUG SECTION** - Remove in production --}}
        @if (count($nodes) === 0)
            <div class="card bg-yellow-50 border-yellow-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <h3 class="text-lg font-medium text-yellow-800">No concepts found</h3>
                    </div>
                    <p class="mt-2 text-yellow-700">
                        This concept map doesn't have any concepts yet. Click "Add Concept" to get started!
                    </p>
                </div>
            </div>
        @endif

        <!-- Interactive Concept Map -->
        <div class="card">
            <div class="p-6">
                <concept-map :nodes='@json($nodes)' :edges='@json($edges)'
                    title="{{ $conceptMap->title }}"
                    autosave-url="{{ route('concept-maps.autosave', $conceptMap) }}"></concept-map>
            </div>
        </div>

        <!-- Concept List -->
        @if (count($nodes) > 0)
            <div class="card">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Concepts Overview</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                        @foreach ($nodes as $node)
                            @php
                                $label = $node['data']['label'] ?? 'Unknown';
                                $category = $node['data']['category'] ?? 'detail';
                                $frequency = $node['data']['frequency'] ?? 0;
                                $color = $node['style']['background'] ?? '#96CEB4';
                            @endphp
                            <div class="concept-item" style="border-left: 4px solid {{ $color }};">
                                <div class="font-medium text-gray-900">{{ $label }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ ucfirst(str_replace('_', ' ', $category)) }}
                                    @if ($frequency > 1)
                                        • {{ $frequency }} mentions
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="card">
            <div class="p-6 flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-600">
                        Last updated: {{ $conceptMap->updated_at->diffForHumans() }}
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('concept-maps.edit', $conceptMap) }}" class="btn-primary">
                        Edit Details
                    </a>
                    <form action="{{ route('concept-maps.destroy', $conceptMap) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this concept map? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                            Delete Map
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .concept-item {
            @apply bg-gray-50 px-3 py-2 rounded-lg border border-gray-200;
        }

        .concept-item:hover {
            @apply bg-gray-100 shadow-sm;
        }
    </style>
</x-app-layout>
