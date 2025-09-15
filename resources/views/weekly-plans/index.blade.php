<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Weekly Plans</h1>
            <p class="text-gray-600 mt-1">Your study schedule and weekly targets</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('weekly-plans.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Plan
            </a>
        </x-slot>
    </x-slot>

    <div class="space-y-6">
        <!-- Filters -->
        <div class="card">
            <div class="p-6">
                <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Semester</label>
                        <select class="form-input">
                            <option value="">All Semesters</option>
                            @foreach(auth()->user()->semesters as $semester)
                                <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                            @endforeach
                        </select>
                    </div>
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
                        <label class="form-label">Status</label>
                        <select class="form-input">
                            <option value="">All Status</option>
                            <option value="planned">Planned</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="missed">Missed</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Weekly Plans -->
        @if($weeklyPlans->isEmpty())
            <div class="card">
                <div class="empty-state">
                    <div class="w-20 h-20 bg-gray-100 rounded-  xl flex items-center justify-center mx-auto mb-4">
                        <x-icons.plan class="w-20 h-20 text-gray-400" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No weekly plans yet</h3>
                    <p class="text-gray-600 mt-2">Weekly plans will be generated when you create a schedule for your courses.</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach($weeklyPlans as $plan)
                    <div class="card hover:shadow-lg transition-shadow">
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $plan->course->name }} - Week {{ $plan->week_number }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $plan->course->semester->name }}</p>
                                </div>
                                <span class="status-badge status-{{ $plan->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $plan->status)) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600 mb-4">{{ $plan->target_text }}</p>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Planned Hours:</span>
                                    <span class="font-medium text-gray-900">{{ $plan->planned_hours }}h</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Pages:</span>
                                    <span class="font-medium text-gray-900">{{ $plan->num_pages }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Media:</span>
                                    <span class="font-medium text-gray-900">
                                        {{ count(is_array($plan->media) ? $plan->media : json_decode($plan->media, true) ?? []) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Updated:</span>
                                    <span class="font-medium text-gray-900">{{ $plan->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div class="mt-6 flex space-x-2">
                                <a href="{{ route('weekly-plans.show', $plan) }}" class="btn-secondary flex-1 text-center">
                                    View Details
                                </a>
                                <a href="{{ route('weekly-plans.edit', $plan) }}" class="btn-secondary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $weeklyPlans->links() }}
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
