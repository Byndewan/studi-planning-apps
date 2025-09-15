<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Study Monitoring</h1>
            <p class="text-gray-600 mt-1">Track your study progress and performance</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('monitorings.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Log Session
            </a>
        </x-slot>
    </x-slot>

    <div class="space-y-6">
        <!-- Filters -->
        <div class="card">
            <div class="p-6">
                <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                        <label class="form-label">Week</label>
                        <select class="form-input">
                            <option value="">All Weeks</option>
                            @for($i = 1; $i <= 14; $i++)
                                <option value="{{ $i }}">Week {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select class="form-input">
                            <option value="">All Status</option>
                            <option value="achieved">Achieved</option>
                            <option value="not_achieved">Not Achieved</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Date Range</label>
                        <input type="text" class="form-input" placeholder="Select date range">
                    </div>
                </form>
            </div>
        </div>

        <!-- Monitoring Entries -->
        @if($monitorings->isEmpty())
            <div class="card">
                <div class="empty-state">
                    <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <x-icons.monitor class="w-8 h-8 text-gray-400" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No monitoring entries yet</h3>
                    <p class="text-gray-600 mt-2">Start tracking your study progress by adding your first monitoring entry.</p>
                    <a href="{{ route('monitorings.create') }}" class="btn-primary mt-6">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Log Session
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach($monitorings as $monitoring)
                    <div class="card hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $monitoring->course->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Week {{ $monitoring->week_number }} • {{ $monitoring->date->format('M d, Y') }}
                                    </p>
                                </div>
                                <span class="status-badge {{ $monitoring->achieved ? 'status-completed' : 'status-missed' }}">
                                    {{ $monitoring->achieved ? 'Achieved' : 'Not Achieved' }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-2">Planned</p>
                                    <p class="text-gray-900">{{ $monitoring->planned }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-2">Actual</p>
                                    <p class="text-gray-900">{{ $monitoring->actual }}</p>
                                </div>
                            </div>

                            @if($monitoring->cause || $monitoring->solution)
                                <div class="border-t border-gray-100 pt-4 mt-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        @if($monitoring->cause)
                                            <div>
                                                <p class="text-sm font-medium text-gray-600 mb-2">Cause of Variance</p>
                                                <p class="text-gray-900 text-sm">{{ $monitoring->cause }}</p>
                                            </div>
                                        @endif
                                        @if($monitoring->solution)
                                            <div>
                                                <p class="text-sm font-medium text-gray-600 mb-2">Solution</p>
                                                <p class="text-gray-900 text-sm">{{ $monitoring->solution }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="mt-6 flex justify-end">
                                <a href="{{ route('monitorings.show', $monitoring) }}" class="btn-secondary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $monitorings->links() }}
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
