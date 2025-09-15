<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            SQ3R - {{ $sq3rSession->module_title }}
        </h2>
        <div class="header-actions space-x-2">
            <a href="{{ route('sq3r.edit', $sq3rSession) }}" class="btn-secondary">
                Edit
            </a>
            <a href="{{ route('courses.show', $sq3rSession->course) }}" class="btn-secondary">
                Back to Course
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Session Info -->
            <div class="card mb-6">
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Course</h4>
                            <p class="text-lg text-gray-900">{{ $sq3rSession->course->name }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Module</h4>
                            <p class="text-lg text-gray-900">{{ $sq3rSession->module_title }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Status</h4>
                            <span class="px-3 py-1 text-sm font-medium rounded-full
                                {{ $sq3rSession->review_notes ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $sq3rSession->review_notes ? 'Completed' : 'In Progress' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SQ3R Steps -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">SQ3R Method Steps</h3>
                </div>

                <div class="card-body space-y-8">
                    <!-- Survey -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-3">1. Survey</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            @if($sq3rSession->survey_notes)
                                <p class="text-gray-900">{{ $sq3rSession->survey_notes }}</p>
                            @else
                                <p class="text-gray-500 italic">No survey notes yet. Skim through headings, subheadings, and summaries to get an overview.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Questions -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-3">2. Questions</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            @if($sq3rSession->questions && count(json_decode($sq3rSession->questions, true)) > 0)
                                <ul class="space-y-2">
                                    @foreach(json_decode($sq3rSession->questions, true) as $index => $question)
                                        <li class="flex items-start">
                                            <span class="text-blue-600 mr-2">{{ $index + 1 }}.</span>
                                            <span class="text-gray-900">{{ $question }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500 italic">No questions generated yet. Turn headings and subheadings into questions.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Read -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-3">3. Read</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            @if($sq3rSession->read_notes)
                                <p class="text-gray-900">{{ $sq3rSession->read_notes }}</p>
                            @else
                                <p class="text-gray-500 italic">No reading notes yet. Read actively while seeking answers to your questions.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Recite -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-3">4. Recite</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            @if($sq3rSession->recite_notes)
                                <p class="text-gray-900">{{ $sq3rSession->recite_notes }}</p>
                            @else
                                <p class="text-gray-500 italic">No recitation notes yet. Summarize what you've learned in your own words.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Review -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-3">5. Review</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            @if($sq3rSession->review_notes)
                                <p class="text-gray-900">{{ $sq3rSession->review_notes }}</p>
                            @else
                                <p class="text-gray-500 italic">No review notes yet. Go back over the material to reinforce your understanding.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="border-t pt-6 flex justify-end space-x-3">
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
    </div>
</x-app-layout>
