<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Weekly Plans') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="card mb-6">
                <div class="card-body">
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

            <!-- Weekly Plans Grid -->
            <div class="grid grid-cols-1 gap-6">
                @if($weeklyPlans->isEmpty())
                    <div class="card text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No weekly plans yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Weekly plans will be generated when you create a schedule for your courses.</p>
                    </div>
                @else
                    @foreach($weeklyPlans as $plan)
                        <div class="card hover:shadow-lg transition-shadow duration-200">
                            <div class="card-header flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">
                                        {{ $plan->course->name }} - Week {{ $plan->week_number }}
                                    </h3>
                                    <p class="text-sm text-gray-500">{{ $plan->course->semester->name }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm font-medium rounded-full
                                    {{ $plan->status === 'completed' ? 'bg-green-100 text-green-800' :
                                       ($plan->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' :
                                       ($plan->status === 'missed' ? 'bg-red-100 text-red-800' :
                                       'bg-blue-100 text-blue-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $plan->status)) }}
                                </span>
                            </div>
                            <div class="card-body">
                                <p class="text-gray-600 mb-4">{{ $plan->target_text }}</p>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <span class="font-medium text-gray-500">Planned Hours:</span>
                                        <span class="ml-2 text-gray-900">{{ $plan->planned_hours }}h</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-500">Pages:</span>
                                        <span class="ml-2 text-gray-900">{{ $plan->num_pages }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-500">Media:</span>
                                        <span class="ml-2 text-gray-900">{{ $plan->media ? count(json_decode($plan->media, true)) : 0 }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-500">Last Updated:</span>
                                        <span class="ml-2 text-gray-900">{{ $plan->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <div class="mt-4 flex space-x-2">
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
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
