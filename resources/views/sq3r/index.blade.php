<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('SQ3R Sessions') }}
        </h2>
        <div class="header-actions">
            <a href="{{ route('sq3r.create') }}" class="btn-primary">
                {{ __('New SQ3R Session') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="card mb-6">
                <div class="card-body">
                    <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                            <label class="form-label">Module</label>
                            <input type="text" class="form-input" placeholder="Search by module title">
                        </div>
                        <div>
                            <label class="form-label">Date Range</label>
                            <input type="text" class="form-input" placeholder="Select date range">
                        </div>
                    </form>
                </div>
            </div>

            <!-- SQ3R Sessions -->
            <div class="space-y-6">
                @if($sessions->isEmpty())
                    <div class="card text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No SQ3R sessions yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Start your active reading journey by creating your first SQ3R session.</p>
                        <div class="mt-6">
                            <a href="{{ route('sq3r.create') }}" class="btn-primary">
                                {{ __('New SQ3R Session') }}
                            </a>
                        </div>
                    </div>
                @else
                    @foreach($sessions as $session)
                        <div class="card hover:shadow-lg transition-shadow duration-200">
                            <div class="card-header flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $session->module_title }}</h3>
                                    <p class="text-sm text-gray-500">
                                        {{ $session->course->name }} • {{ $session->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($session->review_notes)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                            In Progress
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body">
                                <!-- Progress Steps -->
                                <div class="mb-6">
                                    <h4 class="text-sm font-medium text-gray-500 mb-3">Progress</h4>
                                    <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                                        <span>Survey</span>
                                        <span>Questions</span>
                                        <span>Read</span>
                                        <span>Recite</span>
                                        <span>Review</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full bg-blue-600"
                                             style="width: {{ $session->review_notes ? '100%' : ($session->recite_notes ? '80%' : ($session->read_notes ? '60%' : ($session->questions ? '40%' : ($session->survey_notes ? '20%' : '0%')))) }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Preview -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                    @if($session->survey_notes)
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Survey Notes</h4>
                                            <p class="mt-1 text-sm text-gray-900 line-clamp-3">{{ $session->survey_notes }}</p>
                                        </div>
                                    @endif
                                    @if($session->review_notes)
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Review Notes</h4>
                                            <p class="mt-1 text-sm text-gray-900 line-clamp-3">{{ $session->review_notes }}</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Questions Preview -->
                                @if($session->questions && count(json_decode($session->questions, true)) > 0)
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-500">Questions</h4>
                                        <div class="mt-2 space-y-1">
                                            @foreach(array_slice(json_decode($session->questions, true), 0, 3) as $question)
                                                <p class="text-sm text-gray-900">• {{ $question }}</p>
                                            @endforeach
                                            @if(count(json_decode($session->questions, true)) > 3)
                                                <p class="text-sm text-gray-500">+{{ count(json_decode($session->questions, true)) - 3 }} more questions</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="flex justify-end">
                                    <a href="{{ route('sq3r.show', $session) }}" class="btn-secondary">
                                        Continue Session
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $sessions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
