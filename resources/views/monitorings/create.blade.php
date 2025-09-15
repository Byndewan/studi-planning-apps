<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Log Study Session') }}
        </h2>
        <div class="header-actions">
            <a href="{{ route('monitorings.index') }}" class="btn-secondary">
                {{ __('Back to Monitoring') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('monitorings.store') }}">
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

                            <!-- Date -->
                            <div>
                                <label class="form-label" for="date">Date *</label>
                                <input type="date"
                                       id="date"
                                       name="date"
                                       value="{{ old('date', now()->format('Y-m-d')) }}"
                                       required
                                       class="form-input @error('date') border-red-500 @enderror"
                                       x-data
                                       x-init="flatpickr($el, {dateFormat: 'Y-m-d', maxDate: 'today'})">
                                @error('date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Week Number -->
                            <div>
                                <label class="form-label" for="week_number">Week Number *</label>
                                <select id="week_number"
                                        name="week_number"
                                        required
                                        class="form-input @error('week_number') border-red-500 @enderror">
                                    <option value="">Select week number</option>
                                    @for($i = 1; $i <= 14; $i++)
                                        <option value="{{ $i }}" {{ old('week_number') == $i ? 'selected' : '' }}>
                                            Week {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @error('week_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Planned Activities -->
                            <div>
                                <label class="form-label" for="planned">Planned Activities *</label>
                                <textarea id="planned"
                                          name="planned"
                                          rows="3"
                                          required
                                          class="form-input @error('planned') border-red-500 @enderror"
                                          placeholder="What did you plan to study?">{{ old('planned') }}</textarea>
                                @error('planned')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Actual Activities -->
                            <div>
                                <label class="form-label" for="actual">Actual Activities *</label>
                                <textarea id="actual"
                                          name="actual"
                                          rows="3"
                                          required
                                          class="form-input @error('actual') border-red-500 @enderror"
                                          placeholder="What did you actually accomplish?">{{ old('actual') }}</textarea>
                                @error('actual')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Cause of Variance -->
                            <div>
                                <label class="form-label" for="cause">Cause of Variance</label>
                                <textarea id="cause"
                                          name="cause"
                                          rows="2"
                                          class="form-input @error('cause') border-red-500 @enderror"
                                          placeholder="Why was there a difference between planned and actual?">{{ old('cause') }}</textarea>
                                @error('cause')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Solution -->
                            <div>
                                <label class="form-label" for="solution">Solution/Improvement</label>
                                <textarea id="solution"
                                          name="solution"
                                          rows="2"
                                          class="form-input @error('solution') border-red-500 @enderror"
                                          placeholder="How can you improve for next time?">{{ old('solution') }}</textarea>
                                @error('solution')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Achieved -->
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox"
                                           id="achieved"
                                           name="achieved"
                                           value="1"
                                           {{ old('achieved') ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-600">Mark as achieved</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-1">
                                    Check if you achieved your main study goals for this session
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
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
            <div class="mt-6 card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Why Monitor Your Study?</h3>
                </div>
                <div class="card-body">
                    <ul class="list-disc list-inside space-y-2 text-sm text-gray-600">
                        <li>Identifies patterns in your study habits</li>
                        <li>Helps you understand what works and what doesn't</li>
                        <li>Provides data to make better study plans</li>
                        <li>Increases accountability and motivation</li>
                        <li>Helps track progress over time</li>
                        <li>Reveals time management issues early</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
