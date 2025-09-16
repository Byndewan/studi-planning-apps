<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit SQ3R Session</h1>
            <p class="text-gray-600 mt-1">{{ $sq3rSession->module_title }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('sq3r.show', $sq3rSession) }}" class="btn-secondary">
                View Session
            </a>
            <a href="{{ route('sq3r.index') }}" class="btn-secondary">
                All Sessions
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <div class="card">
            <div class="p-8">
                <form method="POST" action="{{ route('sq3r.update', $sq3rSession) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="course_id" value="{{ $sq3rSession->course_id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Course Info (Read-only) -->
                        <div>
                            <x-input-label value="Course" />
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $sq3rSession->course->name }}</p>
                            <p class="text-sm text-gray-600">{{ $sq3rSession->course->semester->name }}</p>
                        </div>

                        <!-- Module Title -->
                        <div>
                            <x-input-label for="module_title" :value="__('Module/Chapter Title')" />
                            <x-text-input id="module_title" type="text" name="module_title" :value="old('module_title', $sq3rSession->module_title)"
                                required />
                            <x-input-error :messages="$errors->get('module_title')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Progress Status -->
                    <div>
                        <x-input-label value="Progress Status" />
                        <div class="mt-2">
                            <div class="flex items-center space-x-4">
                                @php
                                    $steps = [
                                        'survey' => [
                                            'icon' => 'S',
                                            'label' => 'Survey',
                                            'completed' => !empty($sq3rSession->survey_notes),
                                        ],
                                        'questions' => [
                                            'icon' => 'Q',
                                            'label' => 'Questions',
                                            'completed' => !empty($sq3rSession->questions),
                                        ],
                                        'read' => [
                                            'icon' => 'R',
                                            'label' => 'Read',
                                            'completed' => !empty($sq3rSession->read_notes),
                                        ],
                                        'recite' => [
                                            'icon' => 'R',
                                            'label' => 'Recite',
                                            'completed' => !empty($sq3rSession->recite_notes),
                                        ],
                                        'review' => [
                                            'icon' => 'R',
                                            'label' => 'Review',
                                            'completed' => !empty($sq3rSession->review_notes),
                                        ],
                                    ];
                                @endphp

                                @foreach ($steps as $step)
                                    <div class="text-center">
                                        <div
                                            class="w-10 h-10 {{ $step['completed'] ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-600' }} rounded-xl flex items-center justify-center mx-auto mb-2">
                                            <span class="font-bold text-sm">{{ $step['icon'] }}</span>
                                        </div>
                                        <span
                                            class="text-xs {{ $step['completed'] ? 'text-green-600' : 'text-gray-600' }}">
                                            {{ $step['label'] }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Survey Notes -->
                    <div>
                        <x-input-label for="survey_notes" :value="__('Survey Notes')" />
                        <textarea id="survey_notes" name="survey_notes" rows="4" class="form-input mt-1 block w-full"
                            placeholder="What did you notice when surveying the material?">{{ old('survey_notes', $sq3rSession->survey_notes) }}</textarea>
                        <x-input-error :messages="$errors->get('survey_notes')" class="mt-2" />
                    </div>

                    <!-- Questions -->
                    <div x-data="questionManager()" x-init="questions = {{ json_encode(old('questions', $sq3rSession->questions ?? ['', '', ''])) }}" class="space-y-4">
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
                    </div>

                    <!-- Read Notes -->
                    <div>
                        <x-input-label for="read_notes" :value="__('Read Notes')" />
                        <textarea id="read_notes" name="read_notes" rows="6" class="form-input mt-1 block w-full"
                            placeholder="What did you learn while reading? What answers did you find to your questions?">{{ old('read_notes', $sq3rSession->read_notes) }}</textarea>
                        <x-input-error :messages="$errors->get('read_notes')" class="mt-2" />
                    </div>

                    <!-- Recite Notes -->
                    <div>
                        <x-input-label for="recite_notes" :value="__('Recite Notes')" />
                        <textarea id="recite_notes" name="recite_notes" rows="4" class="form-input mt-1 block w-full"
                            placeholder="Summarize what you've learned in your own words...">{{ old('recite_notes', $sq3rSession->recite_notes) }}</textarea>
                        <x-input-error :messages="$errors->get('recite_notes')" class="mt-2" />
                    </div>

                    <!-- Review Notes -->
                    <div>
                        <x-input-label for="review_notes" :value="__('Review Notes')" />
                        <textarea id="review_notes" name="review_notes" rows="4" class="form-input mt-1 block w-full"
                            placeholder="What key points should you remember? What needs more review?">{{ old('review_notes', $sq3rSession->review_notes) }}</textarea>
                        <x-input-error :messages="$errors->get('review_notes')" class="mt-2" />
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('sq3r.show', $sq3rSession) }}" class="btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            Update Session
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Session Information -->
        <div class="card">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Session Information</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Created:</span>
                        <span class="text-gray-900 ml-2">{{ $sq3rSession->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="text-gray-900 ml-2">{{ $sq3rSession->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Status:</span>
                        <span
                            class="ml-2 px-2 py-1 text-xs font-medium rounded-full {{ $sq3rSession->review_notes ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $sq3rSession->review_notes ? 'Completed' : 'In Progress' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="card border border-red-200">
            <div class="p-6 bg-red-50 border-b border-red-200">
                <h3 class="text-lg font-semibold text-red-800">Danger Zone</h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">
                    Once you delete this SQ3R session, there is no going back. Please be certain.
                </p>
                <form action="{{ route('sq3r.destroy', $sq3rSession) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this SQ3R session? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                        Delete Session
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
