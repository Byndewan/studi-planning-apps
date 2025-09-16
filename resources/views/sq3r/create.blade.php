<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">New SQ3R Session</h1>
            <p class="text-gray-600 mt-1">Start an active reading session using the SQ3R method</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('sq3r.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Sessions
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="card">
            <div class="p-8">
                <form method="POST" action="{{ route('sq3r.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Course Selection -->
                        <div>
                            <x-input-label for="course_id" :value="__('Course')" />
                            <select id="course_id" name="course_id" required
                                class="form-input @error('course_id') border-red-500 @enderror">
                                <option value="">Select a course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }} ({{ $course->semester->name }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                        </div>

                        <!-- Module Title -->
                        <div>
                            <x-input-label for="module_title" :value="__('Module/Chapter Title')" />
                            <x-text-input id="module_title" type="text" name="module_title" :value="old('module_title')"
                                required placeholder="e.g., Chapter 1: Introduction to Physics" />
                            <x-input-error :messages="$errors->get('module_title')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Survey Notes -->
                    <div>
                        <x-input-label for="survey_notes" :value="__('Survey Notes')" />
                        <textarea id="survey_notes" name="survey_notes" rows="4"
                            class="form-input @error('survey_notes') border-red-500 @enderror"
                            placeholder="Skim through headings, subheadings, images, and summaries. Note down the main ideas and structure...">{{ old('survey_notes') }}</textarea>
                        <x-input-error :messages="$errors->get('survey_notes')" class="mt-2" />
                        <p class="text-xs text-gray-500 mt-1">Quickly scan the material to get an overview before diving
                            in.</p>
                    </div>

                    <!-- Questions -->
                    <div x-data="questionManager()" class="space-y-4">
                        <x-input-label value="Questions" />

                        <template x-for="(question, index) in questions" :key="'question-' + index">
                            <div class="mb-3 flex items-center space-x-2">
                                <span
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-medium text-gray-600"
                                    x-text="index + 1"></span>
                                <input type="text" :name="'questions[' + index + ']'" x-model="questions[index]"
                                    class="form-input flex-1" :placeholder="'Question ' + (index + 1)" />
                                <button type="button" @click="removeQuestion(index)" x-show="questions.length > 1"
                                    class="text-red-500 hover:text-red-700 text-sm px-2 py-1">
                                    ✕
                                </button>
                            </div>
                        </template>

                        <div class="flex space-x-2 mt-2">
                            <button type="button" @click="addQuestion"
                                class="flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Question
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('questions')" class="mt-2" />
                        <p class="text-xs text-gray-500 mt-1">Turn headings into questions to guide your reading.</p>
                    </div>

                    <!-- Read Notes -->
                    <div>
                        <x-input-label for="read_notes" :value="__('Read Notes')" />
                        <textarea id="read_notes" name="read_notes" rows="5" class="form-input"
                            placeholder="What did you learn while reading? What answers did you find to your questions?">{{ old('read_notes') }}</textarea>
                        <x-input-error :messages="$errors->get('read_notes')" class="mt-2" />
                        <p class="text-xs text-gray-500 mt-1">Read carefully while seeking answers to your questions.
                        </p>
                    </div>

                    <!-- Recite Notes -->
                    <div>
                        <x-input-label for="recite_notes" :value="__('Recite Notes')" />
                        <textarea id="recite_notes" name="recite_notes" rows="4" class="form-input"
                            placeholder="Summarize what you've learned in your own words...">{{ old('recite_notes') }}</textarea>
                        <x-input-error :messages="$errors->get('recite_notes')" class="mt-2" />
                    </div>

                    <!-- Review Notes -->
                    <div>
                        <x-input-label for="review_notes" :value="__('Review Notes')" />
                        <textarea id="review_notes" name="review_notes" rows="4" class="form-input"
                            placeholder="What key points should you remember? What needs more review?">{{ old('review_notes') }}</textarea>
                        <x-input-error :messages="$errors->get('review_notes')" class="mt-2" />
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
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
        <div class="card mt-6">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">About SQ3R Method</h3>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 text-center">
                    <div class="p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <div
                            class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center mx-auto mb-3">
                            <span class="font-bold">S</span>
                        </div>
                        <p class="font-medium text-gray-900">Survey</p>
                        <p class="text-xs text-gray-600 mt-1">Skim the material first</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-xl border border-green-200">
                        <div
                            class="w-10 h-10 bg-green-600 text-white rounded-xl flex items-center justify-center mx-auto mb-3">
                            <span class="font-bold">Q</span>
                        </div>
                        <p class="font-medium text-gray-900">Question</p>
                        <p class="text-xs text-gray-600 mt-1">Generate questions</p>
                    </div>
                    <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                        <div
                            class="w-10 h-10 bg-yellow-600 text-white rounded-xl flex items-center justify-center mx-auto mb-3">
                            <span class="font-bold">R</span>
                        </div>
                        <p class="font-medium text-gray-900">Read</p>
                        <p class="text-xs text-gray-600 mt-1">Read actively</p>
                    </div>
                    <div class="p-4 bg-purple-50 rounded-xl border border-purple-200">
                        <div
                            class="w-10 h-10 bg-purple-600 text-white rounded-xl flex items-center justify-center mx-auto mb-3">
                            <span class="font-bold">R</span>
                        </div>
                        <p class="font-medium text-gray-900">Recite</p>
                        <p class="text-xs text-gray-600 mt-1">Summarize in your words</p>
                    </div>
                    <div class="p-4 bg-red-50 rounded-xl border border-red-200">
                        <div
                            class="w-10 h-10 bg-red-600 text-white rounded-xl flex items-center justify-center mx-auto mb-3">
                            <span class="font-bold">R</span>
                        </div>
                        <p class="font-medium text-gray-900">Review</p>
                        <p class="text-xs text-gray-600 mt-1">Reinforce learning</p>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-gray-50 rounded-xl">
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
</x-app-layout>
