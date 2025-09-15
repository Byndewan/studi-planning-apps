<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Semester</h1>
            <p class="text-gray-600 mt-1">{{ $semester->name }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('semesters.show', $semester) }}" class="btn-secondary">
                View Semester
            </a>
            <a href="{{ route('semesters.index') }}" class="btn-secondary">
                All Semesters
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="card">
            <div class="p-8">
                <form method="POST" action="{{ route('semesters.update', $semester) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Semester Name -->
                    <div>
                        <x-input-label for="name" :value="__('Semester Name')" />
                        <x-text-input id="name" type="text" name="name" :value="old('name', $semester->name)" required
                                      placeholder="e.g., Fall 2024, Spring 2025" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Start Date -->
                        <div>
                            <x-input-label for="start_date" :value="__('Start Date')" />
                            <x-text-input id="start_date" type="date" name="start_date" :value="old('start_date', $semester->start_date->format('Y-m-d'))" required
                                          class="form-input @error('start_date') border-red-500 @enderror" />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>

                        <!-- End Date -->
                        <div>
                            <x-input-label for="end_date" :value="__('End Date')" />
                            <x-text-input id="end_date" type="date" name="end_date" :value="old('end_date', $semester->end_date->format('Y-m-d'))" required
                                          class="form-input @error('end_date') border-red-500 @enderror" />
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <x-input-label value="Current Status" />
                        <div class="mt-2">
                            <span class="px-3 py-1 text-sm font-medium rounded-full {{ $semester->is_current ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $semester->is_current ? 'Current Semester' : 'Past Semester' }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Status is automatically determined based on current date.
                        </p>
                    </div>

                    <!-- Courses Count -->
                    <div>
                        <x-input-label value="Courses in this Semester" />
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $semester->courses_count }} courses</p>
                        @if($semester->courses_count > 0)
                            <p class="text-xs text-gray-500 mt-1">
                                Editing dates may affect all courses in this semester.
                            </p>
                        @endif
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('semesters.show', $semester) }}" class="btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            Update Semester
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        @if($semester->courses_count === 0)
            <div class="card border border-red-200">
                <div class="p-6 bg-red-50 border-b border-red-200">
                    <h3 class="text-lg font-semibold text-red-800">Danger Zone</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-4">
                        Once you delete a semester, there is no going back. Please be certain.
                    </p>
                    <form action="{{ route('semesters.destroy', $semester) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this semester? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                            Delete Semester
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="card border border-yellow-200">
                <div class="p-6 bg-yellow-50 border-b border-yellow-200">
                    <h3 class="text-lg font-semibold text-yellow-800">Delete Restricted</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-yellow-700 mb-4">
                        This semester cannot be deleted because it contains courses.
                        Please delete all courses first before deleting the semester.
                    </p>
                    <a href="{{ route('semesters.show', $semester) }}" class="btn-secondary">
                        View Courses
                    </a>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Client-side validation for date consistency
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            function validateDates() {
                if (startDateInput.value && endDateInput.value) {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);

                    if (endDate <= startDate) {
                        endDateInput.setCustomValidity('End date must be after start date');
                    } else {
                        endDateInput.setCustomValidity('');
                    }
                }
            }

            startDateInput.addEventListener('change', validateDates);
            endDateInput.addEventListener('change', validateDates);

            // Initial validation
            validateDates();
        });
    </script>
</x-app-layout>
