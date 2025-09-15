<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $weeklyPlan->course->name }} - Week {{ $weeklyPlan->week_number }}</h1>
            <p class="text-gray-600 mt-1">{{ $weeklyPlan->course->semester->name }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('weekly-plans.edit', $weeklyPlan) }}" class="btn-secondary">
                Edit Plan
            </a>
            <a href="{{ route('courses.show', $weeklyPlan->course) }}" class="btn-secondary">
                Back to Course
            </a>
        </x-slot>
    </x-slot>

    <div class="space-y-6">
        <!-- Plan Info -->
        <div class="card">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Course</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $weeklyPlan->course->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Week Number</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $weeklyPlan->week_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $weeklyPlan->status === 'completed' ? 'bg-green-100 text-green-800' : ($weeklyPlan->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : ($weeklyPlan->status === 'missed' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                            {{ ucfirst(str_replace('_', ' ', $weeklyPlan->status)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Details -->
        <div class="card">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Plan Details</h2>
                <p class="text-gray-900">{{ $weeklyPlan->target_text }}</p>
            </div>
        </div>

        <!-- Plan Statistics -->
        <div class="card">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Plan Statistics</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-600">Planned Hours:</span>
                        <span class="ml-2 text-gray-900">{{ $weeklyPlan->planned_hours }}h</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Pages:</span>
                        <span class="ml-2 text-gray-900">{{ $weeklyPlan->num_pages }}</span>
                    </div>
                    <span class="ml-2 text-gray-900">
                        {{ count(is_array($weeklyPlan->media) ? $weeklyPlan->media : json_decode($weeklyPlan->media, true) ?? []) }}
                    </span>
                    <div>
                        <span class="font-medium text-gray-600">Last Updated:</span>
                        <span class="ml-2 text-gray-900">{{ $weeklyPlan->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card">
            <div class="p-6">
                <div class="flex justify-end">
                    <a href="{{ route('weekly-plans.edit', $weeklyPlan) }}" class="btn-secondary">
                        Edit Plan
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
