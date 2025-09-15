<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Log Study Session</h1>
            <p class="text-gray-600 mt-1">Track your study progress and identify areas for improvement</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('monitorings.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Monitoring
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="card">
            <div class="p-8">
                <form method="POST" action="{{ route('monitorings.store') }}" class="space-y-6">
                    @csrf

                    <!-- Course Selection -->
                    <div>
                        <x-input-label for="course_id" :value="__('Course')" />
                        <select id="course_id" name="course_id" required
                                class="form-input @error('course_id') border-red-500 @enderror">
                            <option value="">Select a course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }} ({{ $course->semester->name }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Date -->
                        <div>
                            <x-input-label for="date" :value="__('Date')" />
                            <x-date-picker name="date" :value="old('date', now()->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <!-- Week Number -->
                        <div>
                            <x-input-label for="week_number" :value="__('Week Number')" />
                            <select id="week_number" name="week_number" required
                                    class="form-input @error('week_number') border-red-500 @enderror">
                                <option value="">Select week number</option>
                                @for($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}" {{ old('week_number') == $i ? 'selected' : '' }}>
                                        Week {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <x-input-error :messages="$errors->get('week_number')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Planned Activities -->
                    <div>
                        <x-input-label for="planned" :value="__('Planned Activities')" />
                        <textarea id="planned" name="planned" rows="3" required
                                  class="form-input @error('planned') border-red-500 @enderror"
                                  placeholder="What did you plan to study?">{{ old('planned') }}</textarea>
                        <x-input-error :messages="$errors->get('planned')" class="mt-2" />
                    </div>

                    <!-- Actual Activities -->
                    <div>
                        <x-input-label for="actual" :value="__('Actual Activities')" />
                        <textarea id="actual" name="actual" rows="3" required
                                  class="form-input @error('actual') border-red-500 @enderror"
                                  placeholder="What did you actually accomplish?">{{ old('actual') }}</textarea>
                        <x-input-error :messages="$errors->get('actual')" class="mt-2" />
                    </div>

                    <!-- Cause of Variance -->
                    <div>
                        <x-input-label for="cause" :value="__('Cause of Variance')" />
                        <textarea id="cause" name="cause" rows="2"
                                  class="form-input @error('cause') border-red-500 @enderror"
                                  placeholder="Why was there a difference between planned and actual?">{{ old('cause') }}</textarea>
                        <x-input-error :messages="$errors->get('cause')" class="mt-2" />
                    </div>

                    <!-- Solution -->
                    <div>
                        <x-input-label for="solution" :value="__('Solution/Improvement')" />
                        <textarea id="solution" name="solution" rows="2"
                                  class="form-input @error('solution') border-red-500 @enderror"
                                  placeholder="How can you improve for next time?">{{ old('solution') }}</textarea>
                        <x-input-error :messages="$errors->get('solution')" class="mt-2" />
                    </div>

                    <!-- Achieved -->
                    <div class="flex items-center">
                        <input type="checkbox" id="achieved" name="achieved" value="1" {{ old('achieved') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <x-input-label for="achieved" :value="__('Mark as achieved')" class="ml-2 mb-0" />
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('monitorings.index') }}" class="btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            Log Session
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Monitoring Benefits -->
        <div class="card mt-6">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Why Monitor Your Study?</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Identifies patterns in your study habits
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Helps you understand what works and what doesn't
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Provides data to make better study plans
                        </li>
                    </ul>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Increases accountability and motivation
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Helps track progress over time
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Reveals time management issues early
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
