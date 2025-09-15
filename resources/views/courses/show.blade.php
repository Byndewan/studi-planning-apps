<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $course->code }} - {{ $course->name }}
        </h2>
        <div class="header-actions space-x-2">
            <a href="{{ route('courses.edit', $course) }}" class="btn-secondary">
                Edit
            </a>
            <a href="{{ route('semesters.show', $course->semester) }}" class="btn-secondary">
                Back to Semester
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Course Info -->
            <div class="card mb-6">
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Course Code</h4>
                            <p class="text-lg text-gray-900">{{ $course->code }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">SKS</h4>
                            <p class="text-lg text-gray-900">{{ $course->sks }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Total Modules</h4>
                            <p class="text-lg text-gray-900">{{ $course->total_modules }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Semester</h4>
                            <p class="text-lg text-gray-900">{{ $course->semester->name }}</p>
                        </div>
                    </div>

                    @if($course->notes)
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500">Notes</h4>
                            <p class="text-gray-900 mt-1">{{ $course->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="-mb-px flex space-x-8">
                    <button @click="activeTab = 'weekly'" :class="{
                        'border-blue-500 text-blue-600': activeTab === 'weekly',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'weekly'
                    }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Weekly Plans
                    </button>
                    <button @click="activeTab = 'monitoring'" :class="{
                        'border-blue-500 text-blue-600': activeTab === 'monitoring',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'monitoring'
                    }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Monitoring
                    </button>
                    <button @click="activeTab = 'sq3r'" :class="{
                        'border-blue-500 text-blue-600': activeTab === 'sq3r',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'sq3r'
                    }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        SQ3R Sessions
                    </button>
                    <button @click="activeTab = 'concepts'" :class="{
                        'border-blue-500 text-blue-600': activeTab === 'concepts',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'concepts'
                    }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Concept Maps
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div x-data="{ activeTab: 'weekly' }">
                <!-- Weekly Plans Tab -->
                <div x-show="activeTab === 'weekly'" class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Weekly Study Plans</h3>
                    </div>

                    @if($course->weeklyPlans->isEmpty())
                        <div class="card text-center py-8">
                            <p class="text-gray-500">No weekly plans yet.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($course->weeklyPlans as $plan)
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="font-medium">Week {{ $plan->week_number }}</h4>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            {{ $plan->status === 'completed' ? 'bg-green-100 text-green-800' :
                                               ($plan->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' :
                                               'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst(str_replace('_', ' ', $plan->status)) }}
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-sm text-gray-600 mb-2">{{ $plan->target_text }}</p>
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
                <div x-show="activeTab === 'monitoring'" class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Study Monitoring</h3>
                        <a href="{{ route('monitorings.create') }}?course_id={{ $course->id }}" class="btn-primary text-sm">
                            Add Entry
                        </a>
                    </div>

                    @if($course->monitorings->isEmpty())
                        <div class="card text-center py-8">
                            <p class="text-gray-500">No monitoring entries yet.</p>
                        </div>
                    @else
                        <div class="card">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Week</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Achieved</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($course->monitorings as $monitoring)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $monitoring->date->format('M d, Y') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Week {{ $monitoring->week_number }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                                        {{ $monitoring->achieved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $monitoring->achieved ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('monitorings.show', $monitoring) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- SQ3R Tab -->
                <div x-show="activeTab === 'sq3r'" class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">SQ3R Sessions</h3>
                        <a href="{{ route('sq3r.create') }}?course_id={{ $course->id }}" class="btn-primary text-sm">
                            New Session
                        </a>
                    </div>

                    @if($course->sq3rSessions->isEmpty())
                        <div class="card text-center py-8">
                            <p class="text-gray-500">No SQ3R sessions yet.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($course->sq3rSessions as $session)
                                <div class="card">
                                    <div class="card-header flex justify-between items-center">
                                        <h4 class="font-medium">{{ $session->module_title }}</h4>
                                        <span class="text-sm text-gray-500">{{ $session->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-sm text-gray-600 line-clamp-2">
                                            {{ Str::limit($session->review_notes ?: $session->read_notes, 100) }}
                                        </p>
                                        <div class="mt-3 flex justify-between items-center">
                                            <span class="text-xs text-gray-500">
                                                {{ $session->questions ? count(json_decode($session->questions, true)) : 0 }} questions
                                            </span>
                                            <a href="{{ route('sq3r.show', $session) }}" class="text-blue-600 hover:text-blue-900 text-sm">
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
                <div x-show="activeTab === 'concepts'" class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Concept Maps</h3>
                        <a href="{{ route('concept-maps.create') }}?course_id={{ $course->id }}" class="btn-primary text-sm">
                            New Map
                        </a>
                    </div>

                    @if($course->conceptMaps->isEmpty())
                        <div class="card text-center py-8">
                            <p class="text-gray-500">No concept maps yet.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($course->conceptMaps as $map)
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="font-medium">{{ $map->title }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="aspect-video bg-gray-100 rounded mb-3 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-xs text-gray-500">
                                                {{ $map->nodes ? count(json_decode($map->nodes, true)) : 0 }} nodes
                                            </span>
                                            <a href="{{ route('concept-maps.show', $map) }}" class="text-blue-600 hover:text-blue-900 text-sm">
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
</x-app-layout>
