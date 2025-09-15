<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('New SQ3R Session') }}
        </h2>
        <div class="header-actions">
            <a href="{{ route('sq3r.index') }}" class="btn-secondary">
                {{ __('Back to Sessions') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('sq3r.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Course Selection -->
                            <div>
                                <label class="form-label" for="course_id">Course *</label>
                                <select id="course_id"
                                        name="course_id"
                                        required
                                        class="form-input @error('course_id') border-red-500 @enderror">
                                    <option value="">Select a course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}"
                                                {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>
                                            {{ $course->name }} ({{ $course->semester->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Module Title -->
                            <div>
                                <label class="form-label" for="module_title">Module/Chapter Title *</label>
                                <input type="text"
                                       id="module_title"
                                       name="module_title"
                                       value="{{ old('module_title') }}"
                                       required
                                       class="form-input @error('module_title') border-red-500 @enderror"
                                       placeholder="e.g., Chapter 1: Introduction to Physics">
                                @error('module_title')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Survey Notes -->
                            <div>
                                <label class="form-label" for="survey_notes">Survey Notes</label>
                                <textarea id="survey_notes"
                                          name="survey_notes"
                                          rows="4"
                                          class="form-input @error('survey_notes') border-red-500 @enderror"
                                          placeholder="Skim through headings, subheadings, images, and summaries. Note down the main ideas and structure...">{{ old('survey_notes') }}</textarea>
                                @error('survey_notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">
                                    Quickly scan the material to get an overview before diving in.
                                </p>
                            </div>

                            <!-- Questions -->
                            <div x-data="{ questions: {{ json_encode(old('questions', ['', '', ''])) }} }">
                                <label class="form-label">Questions</label>
                                <template x-for="(question, index) in questions" :key="index">
                                    <div class="mb-2">
                                        <input type="text"
                                               :name="'questions[' + index + ']'"
                                               x-model="questions[index]"
                                               class="form-input w-full"
                                               :placeholder="'Question ' + (index + 1)">
                                    </div>
                                </template>

                                <div class="flex space-x-2 mt-2">
                                    <button type="button"
                                            @click="questions.push('')"
                                            class="flex items-center text-sm text-blue-600 hover:text-blue-800">
                                        <x-icons.plus class="w-4 h-4 mr-1" />
                                        Add Question
                                    </button>

                                    <button type="button"
                                            @click="if (questions.length > 1) questions.pop()"
                                            class="flex items-center text-sm text-red-600 hover:text-red-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                        Remove Last
                                    </button>
                                </div>
                                @error('questions')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">
                                    Turn headings into questions to guide your reading.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('sq3r.index') }}" class="btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn-primary">
                                Start SQ3R Session
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SQ3R Method Explanation -->
            <div class="mt-6 card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">About SQ3R Method</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 text-sm">
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="font-bold">S</span>
                            </div>
                            <p class="font-medium">Survey</p>
                            <p class="text-xs text-gray-600">Skim the material first</p>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="font-bold">Q</span>
                            </div>
                            <p class="font-medium">Question</p>
                            <p class="text-xs text-gray-600">Generate questions</p>
                        </div>
                        <div class="text-center p-3 bg-yellow-50 rounded-lg">
                            <div class="w-8 h-8 bg-yellow-600 text-white rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="font-bold">R</span>
                            </div>
                            <p class="font-medium">Read</p>
                            <p class="text-xs text-gray-600">Read actively</p>
                        </div>
                        <div class="text-center p-3 bg-purple-50 rounded-lg">
                            <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="font-bold">R</span>
                            </div>
                            <p class="font-medium">Recite</p>
                            <p class="text-xs text-gray-600">Summarize in your words</p>
                        </div>
                        <div class="text-center p-3 bg-red-50 rounded-lg">
                            <div class="w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="font-bold">R</span>
                            </div>
                            <p class="font-medium">Review</p>
                            <p class="text-xs text-gray-600">Reinforce learning</p>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-2">Why SQ3R Works:</h4>
                        <ul class="list-disc list-inside space-y-1 text-sm text-gray-600">
                            <li>Improves comprehension and retention</li>
                            <li>Helps identify key concepts</li>
                            <li>Makes reading more active and engaging</li>
                            <li>Provides a structured approach to studying</li>
                            <li>Creates ready-made study materials</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
