<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Edit Monitoring Entry') }}
        </h2>
        <div class="header-actions space-x-2">
            <a href="{{ route('monitorings.show', $monitoring) }}" class="btn-secondary">
                View Entry
            </a>
            <a href="{{ route('monitorings.index') }}" class="btn-secondary">
                All Entries
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('monitorings.update', $monitoring) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Course Info (Read-only) -->
                            <div>
                                <label class="form-label">Course</label>
                                <p class="text-lg text-gray-900">{{ $monitoring->course->name }}</p>
                                <p class="text-sm text-gray-500">{{ $monitoring->course->semester->name }}</p>
                            </div>

                            <!-- Date -->
                            <div>
                                <label class="form-label" for="date">Date *</label>
                                <input type="date"
                                       id="date"
                                       name="date"
                                       value="{{ old('date', $monitoring->date->format('Y-m-d')) }}"
                                       required
                                       class="form-input @error('date') border-red-500 @enderror">
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
                                    @for($i = 1; $i <= 14; $i++)
                                        <option value="{{ $i }}" {{ old('week_number', $monitoring->week_number) == $i ? 'selected' : '' }}>
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
                                          class="form-input @error('planned') border-red-500 @enderror">{{ old('planned', $monitoring->planned) }}</textarea>
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
                                          class="form-input @error('actual') border-red-500 @enderror">{{ old('actual', $monitoring->actual) }}</textarea>
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
                                          class="form-input @error('cause') border-red-500 @enderror">{{ old('cause', $monitoring->cause) }}</textarea>
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
                                          class="form-input @error('solution') border-red-500 @enderror">{{ old('solution', $monitoring->solution) }}</textarea>
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
                                           {{ old('achieved', $monitoring->achieved) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-600">Mark as achieved</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('monitorings.show', $monitoring) }}" class="btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn-primary">
                                Update Entry
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Entry Information -->
            <div class="mt-6 card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Entry Information</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Created:</span>
                            <span class="text-gray-900">{{ $monitoring->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Last Updated:</span>
                            <span class="text-gray-900">{{ $monitoring->updated_at->format('M d, Y H:i') }}</span>
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
                        Once you delete this monitoring entry, there is no going back. Please be certain.
                    </p>
                    <form action="{{ route('monitorings.destroy', $monitoring) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this monitoring entry? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                            Delete Entry
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
