<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">SQ3R Sessions</h1>
            <p class="text-gray-600 mt-1">Active reading sessions using the SQ3R method</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('sq3r.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Session
            </a>
        </x-slot>
    </x-slot>

    <div class="space-y-6">
        <!-- Filters -->
        <div class="card">
            <div class="p-6">
                <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Course</label>
                        <select class="form-input">
                            <option value="">All Courses</option>
                            @foreach (auth()->user()->courses as $course)
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
        @if ($sessions->isEmpty())
            <div class="card">
                <div class="empty-state">
                    <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <x-icons.book class="w-8 h-8 text-gray-400" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No SQ3R sessions yet</h3>
                    <p class="text-gray-600 mt-2">Start your active reading journey by creating your first SQ3R session.
                    </p>
                    <a href="{{ route('sq3r.create') }}" class="btn-primary">
                        New Session
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($sessions as $session)
                    <div class="card hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $session->module_title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $session->course->name }} • {{ $session->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if ($session->review_notes)
                                        <span class="status-badge status-completed">
                                            Completed
                                        </span>
                                    @else
                                        <span class="status-badge status-in-progress">
                                            In Progress
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Progress Steps -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                                    <span>Survey</span>
                                    <span>Questions</span>
                                    <span>Read</span>
                                    <span>Recite</span>
                                    <span>Review</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill"
                                        style="width: {{ $session->review_notes ? '100%' : ($session->recite_notes ? '80%' : ($session->read_notes ? '60%' : ($session->questions ? '40%' : ($session->survey_notes ? '20%' : '0%')))) }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Preview -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                @if ($session->survey_notes)
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 mb-2">Survey Notes</p>
                                        <p class="text-gray-900 text-sm line-clamp-3">{{ $session->survey_notes }}</p>
                                    </div>
                                @endif
                                @if ($session->review_notes)
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 mb-2">Review Notes</p>
                                        <p class="text-gray-900 text-sm line-clamp-3">{{ $session->review_notes }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Questions Preview -->
                            @php
                                $questions = is_array($session->questions)
                                    ? $session->questions
                                    : json_decode($session->questions, true) ?? [];
                            @endphp

                            @if (count($questions) > 0)
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-600 mb-2">Questions</p>
                                    <div class="space-y-1">
                                        @foreach (array_slice($questions, 0, 3) as $question)
                                            <p class="text-sm text-gray-900">• {{ $question }}</p>
                                        @endforeach

                                        @if (count($questions) > 3)
                                            <p class="text-sm text-gray-500">
                                                +{{ count($questions) - 3 }} more questions
                                            </p>
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
            </div>
        @endif
    </div>
</x-app-layout>
