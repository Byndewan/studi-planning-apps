<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Edit SQ3R Session') }}: {{ $sq3rSession->module_title }}
        </h2>
        <div class="header-actions space-x-2">
            <a href="{{ route('sq3r.show', $sq3rSession) }}" class="btn-secondary">
                View Session
            </a>
            <a href="{{ route('sq3r.index') }}" class="btn-secondary">
                All Sessions
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('sq3r.update', $sq3rSession) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Course Info (Read-only) -->
                            <div>
                                <label class="form-label">Course</label>
                                <p class="text-lg text-gray-900">{{ $sq3rSession->course->name }}</p>
                                <p class="text-sm text-gray-500">{{ $sq3rSession->course->semester->name }}</p>
                            </div>

                            <!-- Module Title -->
                            <div>
                                <label class="form-label" for="module_title">Module/Chapter Title *</label>
                                <input type="text"
                                       id="module_title"
                                       name="module_title"
                                       value="{{ old('module_title', $sq3rSession->module_title) }}"
                                       required
                                       class="form-input @error('module_title') border-red-500 @enderror">
                                @error('module_title')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Progress Status -->
                            <div>
                                <label class="form-label">Progress Status</label>
                                <div class="mt-2">
                                    <div class="flex items-center space-x-4">
                                        @php
                                            $steps = [
                                                'survey' => ['icon' => 'S', 'label' => 'Survey', 'completed' => !empty($sq3rSession->survey_notes)],
                                                'questions' => ['icon' => 'Q', 'label' => 'Questions', 'completed' => !empty($sq3rSession->questions)],
                                                'read' => ['icon' => 'R', 'label' => 'Read', 'completed' => !empty($sq3rSession->read_notes)],
                                                'recite' => ['icon' => 'R', 'label' => 'Recite', 'completed' => !empty($sq3rSession->recite_notes)],
                                                'review' => ['icon' => 'R', 'label' => 'Review', 'completed' => !empty($sq3rSession->review_notes)],
                                            ];
                                        @endphp

                                        @foreach($steps as $step)
                                            <div class="text-center">
                                                <div class="w-8 h-8 {{ $step['completed'] ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-600' }} rounded-full flex items-center justify-center mx-auto mb-1">
                                                    <span class="font-bold text-sm">{{ $step['icon'] }}</span>
                                                </div>
                                                <span class="text-xs {{ $step['completed'] ? 'text-green-600' : 'text-gray-600' }}">
                                                    {{ $step['label'] }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Survey Notes -->
                            <div>
                                <label class="form-label" for="survey_notes">Survey Notes</label>
                                <textarea id="survey_notes"
                                          name="survey_notes"
                                          rows="4"
                                          class="form-input @error('survey_notes') border-red-500 @enderror"
                                          placeholder="What did you notice when surveying the material?">{{ old('survey_notes', $sq3rSession->survey_notes) }}</textarea>
                                @error('survey_notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Questions -->
                            <div x-data="{ questions: {{ json_encode(old('questions', $sq3rSession->questions ?? ['', '', ''])) }} }">
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
                            </div>

                            <!-- Read Notes -->
                            <div>
                                <label class="form-label" for="read_notes">Read Notes</label>
                                <textarea id="read_notes"
                                          name="read_notes"
                                          rows="6"
                                          class="form-input @error('read_notes') border-red-500 @enderror"
                                          placeholder="What did you learn while reading? What answers did you find to your questions?">{{ old('read_notes', $sq3rSession->read_notes) }}</textarea>
                                @error('read_notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Recite Notes -->
                            <div>
                                <label class="form-label" for="recite_notes">Recite Notes</label>
                                <textarea id="recite_notes"
                                          name="recite_notes"
                                          rows="4"
                                          class="form-input @error('recite_notes') border-red-500 @enderror"
                                          placeholder="Summarize what you've learned in your own words...">{{ old('recite_notes', $sq3rSession->recite_notes) }}</textarea>
                                @error('recite_notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Review Notes -->
                            <div>
                                <label class="form-label" for="review_notes">Review Notes</label>
                                <textarea id="review_notes"
                                          name="review_notes"
                                          rows="4"
                                          class="form-input @error('review_notes') border-red-500 @enderror"
                                          placeholder="What key points should you remember? What needs more review?">{{ old('review_notes', $sq3rSession->review_notes) }}</textarea>
                                @error('review_notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
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
            <div class="mt-6 card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Session Information</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Created:</span>
                            <span class="text-gray-900">{{ $sq3rSession->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Last Updated:</span>
                            <span class="text-gray-900">{{ $sq3rSession->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Time Spent:</span>
                            <span class="text-gray-900">
                                @php
                                    $timestamps = json_decode($sq3rSession->timestamps, true);
                                    if ($timestamps && isset($timestamps['started_at'])) {
                                        $started = \Carbon\Carbon::parse($timestamps['started_at']);
                                        $completed = isset($timestamps['completed_at'])
                                            ? \Carbon\Carbon::parse($timestamps['completed_at'])
                                            : now();
                                        echo $started->diffForHumans($completed, true);
                                    } else {
                                        echo 'N/A';
                                    }
                                @endphp
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500">Status:</span>
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                {{ $sq3rSession->review_notes ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $sq3rSession->review_notes ? 'Completed' : 'In Progress' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="mt-6 card border border-red-200">
                <div class="card-header bg-red-50 border-b border-red-200">
                    <h3 class="text-lg font-medium text-red-800">Danger Zone</h3>
                </div>
                <div class="card-body">
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
    </div>

    <script>
        // Auto-resize textareas
        document.addEventListener('DOMContentLoaded', function() {
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });

                // Trigger initial resize
                textarea.dispatchEvent(new Event('input'));
            });
        });
    </script>
</x-app-layout>
