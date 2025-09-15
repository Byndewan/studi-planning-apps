<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">SQ3R Session</h1>
            <p class="text-gray-600 mt-1">{{ $sq3rSession->module_title }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('sq3r.edit', $sq3rSession) }}" class="btn-secondary">
                Edit Session
            </a>
            <a href="{{ route('courses.show', $sq3rSession->course) }}" class="btn-secondary">
                Back to Course
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Session Info -->
        <div class="card">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Course</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $sq3rSession->course->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Module</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $sq3rSession->module_title }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- SQ3R Steps -->
        <div class="card">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">SQ3R Method Steps</h2>

                <!-- Survey -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">1. Survey</h3>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        @if ($sq3rSession->survey_notes)
                            <p class="text-gray-900">{{ $sq3rSession->survey_notes }}</p>
                        @else
                            <p class="text-gray-600 italic">No survey notes yet. Skim through headings, subheadings, and
                                summaries to get an overview.</p>
                        @endif
                    </div>
                </div>

                <!-- Questions -->
                @php
                    $questions = is_array($sq3rSession->questions)
                        ? $sq3rSession->questions
                        : json_decode($sq3rSession->questions, true) ?? [];
                @endphp
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">2. Questions</h3>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        @if (count($questions) > 0)
                            <ul class="space-y-2">
                                @foreach ($questions as $index => $question)
                                    <li class="flex items-start">
                                        <span class="text-indigo-600 mr-2">{{ $index + 1 }}.</span>
                                        <span class="text-gray-900">{{ $question }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-600 italic">No questions generated yet. Turn headings and subheadings
                                into questions.</p>
                        @endif
                    </div>
                </div>

                <!-- Read -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">3. Read</h3>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        @if ($sq3rSession->read_notes)
                            <p class="text-gray-900">{{ $sq3rSession->read_notes }}</p>
                        @else
                            <p class="text-gray-600 italic">No reading notes yet. Read actively while seeking answers to
                                your questions.</p>
                        @endif
                    </div>
                </div>

                <!-- Recite -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">4. Recite</h3>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        @if ($sq3rSession->recite_notes)
                            <p class="text-gray-900">{{ $sq3rSession->recite_notes }}</p>
                        @else
                            <p class="text-gray-600 italic">No recitation notes yet. Summarize what you've learned in
                                your own words.</p>
                        @endif
                    </div>
                </div>

                <!-- Review -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">5. Review</h3>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        @if ($sq3rSession->review_notes)
                            <p class="text-gray-900">{{ $sq3rSession->review_notes }}</p>
                        @else
                            <p class="text-gray-600 italic">No review notes yet. Go back over the material to reinforce
                                your understanding.</p>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="border-t border-gray-200 pt-6 flex justify-end space-x-3">
                    <a href="{{ route('sq3r.edit', $sq3rSession) }}" class="btn-secondary">
                        Edit Session
                    </a>
                    <form action="{{ route('sq3r.destroy', $sq3rSession) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this SQ3R session?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
