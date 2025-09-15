<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Study Monitoring') }}
        </h2>
        <div class="header-actions">
            <a href="{{ route('monitorings.create') }}" class="btn-primary">
                {{ __('Add New Entry') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="card mb-6">
                <div class="card-body">
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
            <div class="space-y-6">
                @if($monitorings->isEmpty())
                    <div class="card text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No monitoring entries yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Start tracking your study progress by adding your first monitoring entry.</p>
                        <div class="mt-6">
                            <a href="{{ route('monitorings.create') }}" class="btn-primary">
                                {{ __('Add New Entry') }}
                            </a>
                        </div>
                    </div>
                @else
                    @foreach($monitorings as $monitoring)
                        <div class="card hover:shadow-lg transition-shadow duration-200">
                            <div class="card-header flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $monitoring->course->name }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Week {{ $monitoring->week_number }} • {{ $monitoring->date->format('M d, Y') }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 text-sm font-medium rounded-full
                                    {{ $monitoring->achieved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $monitoring->achieved ? 'Achieved' : 'Not Achieved' }}
                                </span>
                            </div>

                            <div class="card-body">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Planned</h4>
                                        <p class="mt-1 text-gray-900">{{ $monitoring->planned }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Actual</h4>
                                        <p class="mt-1 text-gray-900">{{ $monitoring->actual }}</p>
                                    </div>
                                </div>

                                @if($monitoring->cause || $monitoring->solution)
                                    <div class="border-t pt-4 mt-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            @if($monitoring->cause)
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-500">Cause of Variance</h4>
                                                    <p class="mt-1 text-sm text-gray-900">{{ $monitoring->cause }}</p>
                                                </div>
                                            @endif
                                            @if($monitoring->solution)
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-500">Solution</h4>
                                                    <p class="mt-1 text-sm text-gray-900">{{ $monitoring->solution }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-4 flex justify-end">
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
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
