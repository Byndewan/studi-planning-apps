<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Weekly Plan</h1>
            <p class="text-gray-600 mt-1">{{ $weeklyPlan->course->name }} - Week {{ $weeklyPlan->week_number }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('weekly-plans.show', $weeklyPlan) }}" class="btn-secondary">
                View Plan
            </a>
            <a href="{{ route('weekly-plans.index') }}" class="btn-secondary">
                All Plans
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="card">
            <div class="p-8">
                <form method="POST" action="{{ route('weekly-plans.update', $weeklyPlan) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Course Info (Read-only) -->
                        <div>
                            <x-input-label value="Course" />
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $weeklyPlan->course->name }}</p>
                            <p class="text-sm text-gray-600">{{ $weeklyPlan->course->semester->name }}</p>
                        </div>

                        <!-- Week Number -->
                        <div>
                            <x-input-label for="week_number" :value="__('Week Number')" />
                            <select id="week_number" name="week_number" required class="form-input mt-1 block w-full">
                                @for($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}" {{ old('week_number', $weeklyPlan->week_number) == $i ? 'selected' : '' }}>
                                        Week {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <x-input-error :messages="$errors->get('week_number')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Target Text -->
                    <div>
                        <x-input-label for="target_text" :value="__('Study Target')" />
                        <textarea id="target_text" name="target_text" rows="4" required
                                  class="form-input mt-1 block w-full">{{ old('target_text', $weeklyPlan->target_text) }}</textarea>
                        <x-input-error :messages="$errors->get('target_text')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Planned Hours -->
                        <div>
                            <x-input-label for="planned_hours" :value="__('Planned Hours')" />
                            <x-text-input id="planned_hours" type="number" name="planned_hours"
                                          :value="old('planned_hours', $weeklyPlan->planned_hours)"
                                          min="0" step="0.5" required class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('planned_hours')" class="mt-2" />
                        </div>

                        <!-- Number of Pages -->
                        <div>
                            <x-input-label for="num_pages" :value="__('Number of Pages')" />
                            <x-text-input id="num_pages" type="number" name="num_pages"
                                          :value="old('num_pages', $weeklyPlan->num_pages)"
                                          min="0" required class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('num_pages')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" required class="form-input mt-1 block w-full">
                                <option value="planned" {{ old('status', $weeklyPlan->status) == 'planned' ? 'selected' : '' }}>Planned</option>
                                <option value="in_progress" {{ old('status', $weeklyPlan->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status', $weeklyPlan->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="missed" {{ old('status', $weeklyPlan->status) == 'missed' ? 'selected' : '' }}>Missed</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Media -->
                    <div>
                        <x-input-label for="media" :value="__('Media Resources')" />
                        <textarea id="media" name="media" rows="3"
                                  class="form-input mt-1 block w-full"
                                  placeholder="Enter URLs or descriptions of media resources (one per line)">{{ old('media', is_array($weeklyPlan->media) ? implode("\n", $weeklyPlan->media) : '') }}</textarea>
                        <x-input-error :messages="$errors->get('media')" class="mt-2" />
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('weekly-plans.show', $weeklyPlan) }}" class="btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            Update Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Plan Information -->
        <div class="card">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Plan Information</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Created:</span>
                        <span class="text-gray-900 ml-2">{{ $weeklyPlan->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="text-gray-900 ml-2">{{ $weeklyPlan->updated_at->format('M d, Y H:i') }}</span>
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
                    Once you delete this weekly plan, there is no going back. Please be certain.
                </p>
                <form action="{{ route('weekly-plans.destroy', $weeklyPlan) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this weekly plan? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                        Delete Plan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
