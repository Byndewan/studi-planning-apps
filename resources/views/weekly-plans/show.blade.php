<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $weeklyPlan->course->name }} - Week {{ $weeklyPlan->week_number }}
        </h2>
        <div class="header-actions space-x-2">
            <a href="{{ route('weekly-plans.edit', $weeklyPlan) }}" class="btn-secondary">
                Edit
            </a>
            <a href="{{ route('courses.show', $weeklyPlan->course) }}" class="btn-secondary">
                Back to Course
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Weekly Study Plan</h3>
                        <p class="text-sm text-gray-500">
                            {{ $weeklyPlan->course->semester->name }} • {{ $weeklyPlan->updated_at->format('M d, Y') }}
                        </p>
                    </div>
                    <span class="px-3 py-1 text-sm font-medium rounded-full
                        {{ $weeklyPlan->status === 'completed' ? 'bg-green-100 text-green-800' :
                           ($weeklyPlan->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' :
                           ($weeklyPlan->status === 'missed' ? 'bg-red-100 text-red-800' :
                           'bg-blue-100 text-blue-800')) }}">
                        {{ ucfirst(str_replace('_', ' ', $weeklyPlan->status)) }}
                    </span>
                </div>

                <div class="card-body space-y-6">
                    <!-- Target -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Study Target</h4>
                        <p class="mt-1 text-gray-900">{{ $weeklyPlan->target_text }}</p>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Planned Hours</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $weeklyPlan->planned_hours }} hours</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Pages to Cover</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $weeklyPlan->num_pages }} pages</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Week Number</h4>
                            <p class="mt-1 text-lg text-gray-900">Week {{ $weeklyPlan->week_number }}</p>
                        </div>
                    </div>

                    <!-- Media -->
                    @if($weeklyPlan->media && count(json_decode($weeklyPlan->media, true)) > 0)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Study Materials</h4>
                            <div class="mt-2 grid grid-cols-2 gap-2">
                                @foreach(json_decode($weeklyPlan->media, true) as $media)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $media }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Progress -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Progress</h4>
                        <div class="mt-2">
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-1">
                                <span>Completion</span>
                                <span>{{ $weeklyPlan->status === 'completed' ? '100%' : ($weeklyPlan->status === 'in_progress' ? '50%' : '0%') }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full
                                    {{ $weeklyPlan->status === 'completed' ? 'bg-green-600 w-full' :
                                       ($weeklyPlan->status === 'in_progress' ? 'bg-yellow-600 w-1/2' :
                                       'bg-gray-600 w-0') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Monitoring -->
                    @if($weeklyPlan->monitorings->count() > 0)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Monitoring Entries</h4>
                            <div class="mt-2 space-y-2">
                                @foreach($weeklyPlan->monitorings as $monitoring)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $monitoring->date->format('M d, Y') }}</p>
                                            <p class="text-sm text-gray-500">{{ Str::limit($monitoring->actual, 50) }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            {{ $monitoring->achieved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $monitoring->achieved ? 'Achieved' : 'Not Achieved' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
