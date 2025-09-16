<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create Weekly Plan</h1>
            <p class="text-gray-600 mt-1">Plan your study schedule for the week</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('weekly-plans.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Plans
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="card">
            <div class="p-8">
                <form method="POST" action="{{ route('weekly-plans.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Course Selection -->
                        <div>
                            <x-input-label for="course_id" :value="__('Course')" />
                            <select id="course_id" name="course_id" required
                                    class="form-input @error('course_id') border-red-500 @enderror">
                                <option value="">Select a course</option>
                                @foreach(auth()->user()->courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }} ({{ $course->semester->name }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                        </div>

                        <!-- Week Number -->
                        <div>
                            <x-input-label for="week_number" :value="__('Week Number')" />
                            <select id="week_number" name="week_number" required
                                    class="form-input @error('week_number') border-red-500 @enderror">
                                <option value="">Select week</option>
                                @for($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}" {{ old('week_number') == $i ? 'selected' : '' }}>
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
                                  class="form-input @error('target_text') border-red-500 @enderror"
                                  placeholder="What do you plan to study this week?">{{ old('target_text') }}</textarea>
                        <x-input-error :messages="$errors->get('target_text')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Planned Hours -->
                        <div>
                            <x-input-label for="planned_hours" :value="__('Planned Hours')" />
                            <x-text-input id="planned_hours" type="number" name="planned_hours" :value="old('planned_hours')"
                                          min="0" step="0.5" required />
                            <x-input-error :messages="$errors->get('planned_hours')" class="mt-2" />
                        </div>

                        <!-- Number of Pages -->
                        <div>
                            <x-input-label for="num_pages" :value="__('Number of Pages')" />
                            <x-text-input id="num_pages" type="number" name="num_pages" :value="old('num_pages')"
                                          min="0" required />
                            <x-input-error :messages="$errors->get('num_pages')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" required
                                    class="form-input @error('status') border-red-500 @enderror">
                                <option value="planned" {{ old('status') == 'planned' ? 'selected' : '' }}>Planned</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="missed" {{ old('status') == 'missed' ? 'selected' : '' }}>Missed</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('weekly-plans.index') }}" class="btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            Create Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
