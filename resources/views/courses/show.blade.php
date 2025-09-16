<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $course->code }} - {{ $course->name }}</h1>
            <p class="text-gray-600 mt-1">{{ $course->semester->name }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('courses.edit', $course) }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Edit
            </a>
            <a href="{{ route('semesters.show', $course->semester) }}" class="btn-secondary">
                Back to Semester
            </a>
        </x-slot>
    </x-slot>

    <div class="space-y-6">
        <!-- Course Info -->
        <div class="card">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Course Code</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $course->code }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">SKS</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $course->sks }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Modules</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $course->total_modules }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Semester</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $course->semester->name }}</p>
                    </div>
                </div>

                @if ($course->notes)
                    <div class="mt-6">
                        <p class="text-sm font-medium text-gray-600">Notes</p>
                        <p class="text-gray-900 mt-2">{{ $course->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Course Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Weekly Plans</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $course->weeklyPlans->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <x-icons.plan class="w-6 h-6 text-blue-600" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Study Sessions</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $course->monitorings->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <x-icons.monitor class="w-6 h-6 text-green-600" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">SQ3R Sessions</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $course->sq3rSessions->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <x-icons.book class="w-6 h-6 text-yellow-600" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="card">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6 py-1">
                    <button data-tab-button="weekly"
                        class="py-4 px-1 border-b-2 font-medium text-sm hover:text-gray-700 hover:border-gray-300 rounded-lg">
                        Weekly Plans
                    </button>
                    <button data-tab-button="monitoring"
                        class="py-4 px-1 border-b-2 font-medium text-sm hover:text-gray-700 hover:border-gray-300 rounded-lg">
                        Monitoring
                    </button>
                    <button data-tab-button="sq3r"
                        class="py-4 px-1 border-b-2 font-medium text-sm hover:text-gray-700 hover:border-gray-300 rounded-lg">
                        SQ3R Sessions
                    </button>
                    <button data-tab-button="concepts"
                        class="py-4 px-1 border-b-2 font-medium text-sm hover:text-gray-700 hover:border-gray-300 rounded-lg">
                        Concept Maps
                    </button>
                </nav>
            </div>

            <div x-data="{ activeTab: 'weekly' }" class="p-6">
                <!-- Weekly Plans Tab -->
                <div data-tab-content="weekly" class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Weekly Study Plans</h3>
                        <a href="{{ route('weekly-plans.create') }}?course_id={{ $course->id }}"
                            class="btn-primary text-sm">
                            Add Plan
                        </a>
                    </div>

                    @if ($course->weeklyPlans->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">No weekly plans yet.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($course->weeklyPlans as $plan)
                                <div class="card">
                                    <div class="p-4 border-b border-gray-100">
                                        <div class="flex justify-between items-center">
                                            <h4 class="font-medium">Week {{ $plan->week_number }}</h4>
                                            <span class="status-badge status-{{ $plan->status }}">
                                                {{ ucfirst(str_replace('_', ' ', $plan->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <p class="text-sm text-gray-600 mb-3">{{ $plan->target_text }}</p>
                                        <div class="flex justify-between items-center text-xs text-gray-500">
                                            <span>{{ $plan->planned_hours }} hours planned</span>
                                            <span>{{ $plan->num_pages }} pages</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Monitoring Tab -->
                <div data-tab-content="monitoring" class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Study Monitoring</h3>
                        <a href="{{ route('monitorings.create') }}?course_id={{ $course->id }}"
                            class="btn-primary text-sm">
                            Add Entry
                        </a>
                    </div>

                    @if ($course->monitorings->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">No monitoring entries yet.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Week</th>
                                        <th>Planned</th>
                                        <th>Achieved</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($course->monitorings as $monitoring)
                                        <tr class="hover:bg-gray-50">
                                            <td>{{ $monitoring->date->format('M d, Y') }}</td>
                                            <td>Week {{ $monitoring->week_number }}</td>
                                            <td>{{ Str::limit($monitoring->planned, 50) }}</td>
                                            <td>
                                                <span
                                                    class="status-badge {{ $monitoring->achieved ? 'status-completed' : 'status-missed' }}">
                                                    {{ $monitoring->achieved ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('monitorings.show', $monitoring) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- SQ3R Tab -->
                <div data-tab-content="sq3r" class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">SQ3R Sessions</h3>
                        <a href="{{ route('sq3r.create') }}?course_id={{ $course->id }}"
                            class="btn-primary text-sm">
                            New Session
                        </a>
                    </div>

                    @if ($course->sq3rSessions->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">No SQ3R sessions yet.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($course->sq3rSessions as $session)
                                <div class="card">
                                    <div class="p-4 border-b border-gray-100">
                                        <div class="flex justify-between items-center">
                                            <h4 class="font-medium">{{ $session->module_title }}</h4>
                                            <span
                                                class="text-sm text-gray-500">{{ $session->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <p class="text-sm text-gray-600 line-clamp-2">
                                            {{ Str::limit($session->review_notes ?: $session->read_notes, 100) }}
                                        </p>
                                        @php
                                            $questions = is_array($session->questions)
                                                ? $session->questions
                                                : json_decode($session->questions, true) ?? [];
                                        @endphp
                                        <div class="mt-3 flex justify-between items-center">
                                            <span class="text-xs text-gray-500">
                                                {{ count($questions) }} questions
                                            </span>
                                            <a href="{{ route('sq3r.show', $session) }}"
                                                class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Concept Maps Tab -->
                <div data-tab-content="concepts" class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Concept Maps</h3>
                        <a href="{{ route('concept-maps.create') }}?course_id={{ $course->id }}"
                            class="btn-primary text-sm">
                            New Map
                        </a>
                    </div>

                    @if ($course->conceptMaps->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">No concept maps yet.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach ($course->conceptMaps as $map)
                                <div class="card">
                                    <div class="p-4 border-b border-gray-100">
                                        <h4 class="font-medium">{{ $map->title }}</h4>
                                    </div>
                                    <div class="p-4">
                                        <div
                                            class="aspect-video bg-gray-100 rounded-lg mb-3 flex items-center justify-center">
                                            <canvas id="map-preview-{{ $map->id }}"
                                                class="w-full h-full"></canvas>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            @php
                                                $nodes = is_array($map->nodes)
                                                    ? $map->nodes
                                                    : json_decode($map->nodes, true) ?? [];
                                            @endphp
                                            <span class="text-xs text-gray-500">
                                                {{ count($nodes) }} nodes
                                            </span>
                                            <a href="{{ route('concept-maps.show', $map) }}"
                                                class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                View Map
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('[data-tab-button]');
            const tabContents = document.querySelectorAll('[data-tab-content]');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabName = this.getAttribute('data-tab-button');

                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    const selectedContent = document.querySelector(
                        `[data-tab-content="${tabName}"]`);
                    if (selectedContent) {
                        selectedContent.classList.remove('hidden');
                    }

                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-indigo-300', 'text-indigo-500',
                            'bg-indigo-50');
                        btn.classList.add('border-transparent', 'text-gray-500',
                            'bg-gray-100');
                    });

                    this.classList.add('border-indigo-300', 'text-indigo-500', 'bg-indigo-50');
                    this.classList.remove('border-transparent', 'text-gray-500', 'bg-gray-100');
                });
            });

            const firstTab = document.querySelector('[data-tab-button]');
            if (firstTab) {
                firstTab.click();
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            const maps = @json($course->conceptMaps);

            maps.forEach(map => {
                const nodes = typeof map.nodes === "string" ? JSON.parse(map.nodes) : map.nodes;
                const canvas = document.getElementById("map-preview-" + map.id);
                if (!canvas || !nodes.length) return;

                const ctx = canvas.getContext("2d");
                const scale = window.devicePixelRatio || 1;
                canvas.width = 300 * scale;
                canvas.height = 150 * scale;
                ctx.scale(scale, scale);

                const nodeWidth = 30;
                const nodeHeight = 20;
                const spacing = 10;

                nodes.slice(0, 15).forEach((node, i) => {
                    const x = (i % 5) * (nodeWidth + spacing) + 10;
                    const y = Math.floor(i / 5) * (nodeHeight + spacing) + 10;

                    ctx.fillStyle = node.color || "#6366f1";
                    ctx.fillRect(x, y, nodeWidth, nodeHeight);

                    ctx.fillStyle = "#fff";
                    ctx.font = "8px sans-serif";
                    ctx.fillText(node.id || "N", x + 3, y + 12);
                });
            });
        });
    </script>
</x-app-layout>
