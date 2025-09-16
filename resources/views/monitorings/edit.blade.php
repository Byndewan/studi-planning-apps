<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Monitoring Entry</h1>
            <p class="text-gray-600 mt-1">{{ $monitoring->date->format('M d, Y') }} - {{ $monitoring->course->name }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('monitorings.show', $monitoring) }}" class="btn-secondary">
                View Entry
            </a>
            <a href="{{ route('monitorings.index') }}" class="btn-secondary">
                All Entries
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="card">
            <div class="p-8">
                <form method="POST" action="{{ route('monitorings.update', $monitoring) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="course_id" value="{{ $monitoring->course_id }}">

                    <!-- Course Info (Read-only) -->
                    <div>
                        <x-input-label value="Course" />
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $monitoring->course->name }}</p>
                        <p class="text-sm text-gray-600">{{ $monitoring->course->semester->name }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Date -->
                        <div>
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" type="date" name="date" :value="old('date', $monitoring->date->format('Y-m-d'))" required class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <!-- Week Number -->
                        <div>
                            <x-input-label for="week_number" :value="__('Week Number')" />
                            <select id="week_number" name="week_number" required class="form-input mt-1 block w-full">
                                @for($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}" {{ old('week_number', $monitoring->week_number) == $i ? 'selected' : '' }}>
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
                        <textarea id="planned" name="planned" rows="3" required class="form-input mt-1 block w-full">{{ old('planned', $monitoring->planned) }}</textarea>
                        <x-input-error :messages="$errors->get('planned')" class="mt-2" />
                    </div>

                    <!-- Actual Activities -->
                    <div>
                        <x-input-label for="actual" :value="__('Actual Activities')" />
                        <textarea id="actual" name="actual" rows="3" required class="form-input mt-1 block w-full">{{ old('actual', $monitoring->actual) }}</textarea>
                        <x-input-error :messages="$errors->get('actual')" class="mt-2" />
                    </div>

                    <!-- Cause of Variance -->
                    <div>
                        <x-input-label for="cause" :value="__('Cause of Variance')" />
                        <textarea id="cause" name="cause" rows="2" class="form-input mt-1 block w-full">{{ old('cause', $monitoring->cause) }}</textarea>
                        <x-input-error :messages="$errors->get('cause')" class="mt-2" />
                    </div>

                    <!-- Solution -->
                    <div>
                        <x-input-label for="solution" :value="__('Solution/Improvement')" />
                        <textarea id="solution" name="solution" rows="2" class="form-input mt-1 block w-full">{{ old('solution', $monitoring->solution) }}</textarea>
                        <x-input-error :messages="$errors->get('solution')" class="mt-2" />
                    </div>

                    <!-- Achieved -->
                    <div class="flex items-center">
                        <input type="checkbox" id="achieved" name="achieved" value="1" {{ old('achieved', $monitoring->achieved) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <x-input-label for="achieved" :value="__('Mark as achieved')" class="ml-2 mb-0" />
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
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
        <div class="card">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Entry Information</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Created:</span>
                        <span class="text-gray-900 ml-2">{{ $monitoring->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="text-gray-900 ml-2">{{ $monitoring->updated_at->format('M d, Y H:i') }}</span>
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
</x-app-layout>
