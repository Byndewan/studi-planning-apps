<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Edit Semester') }}: {{ $semester->name }}
        </h2>
        <div class="header-actions space-x-2">
            <a href="{{ route('semesters.show', $semester) }}" class="btn-secondary">
                View Semester
            </a>
            <a href="{{ route('semesters.index') }}" class="btn-secondary">
                All Semesters
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('semesters.update', $semester) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Semester Name -->
                            <div>
                                <label class="form-label" for="name">Semester Name *</label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $semester->name) }}"
                                       required
                                       class="form-input @error('name') border-red-500 @enderror"
                                       placeholder="e.g., Fall 2024, Spring 2025">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label class="form-label" for="start_date">Start Date *</label>
                                <input type="date"
                                       id="start_date"
                                       name="start_date"
                                       value="{{ old('start_date', $semester->start_date->format('Y-m-d')) }}"
                                       required
                                       class="form-input @error('start_date') border-red-500 @enderror"
                                       x-data
                                       x-init="flatpickr($el, {dateFormat: 'Y-m-d'})">
                                @error('start_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div>
                                <label class="form-label" for="end_date">End Date *</label>
                                <input type="date"
                                       id="end_date"
                                       name="end_date"
                                       value="{{ old('end_date', $semester->end_date->format('Y-m-d')) }}"
                                       required
                                       class="form-input @error('end_date') border-red-500 @enderror"
                                       x-data
                                       x-init="flatpickr($el, {dateFormat: 'Y-m-d'})">
                                @error('end_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="form-label">Current Status</label>
                                <div class="mt-2">
                                    <span class="px-3 py-1 text-sm font-medium rounded-full
                                        {{ $semester->is_current ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $semester->is_current ? 'Current Semester' : 'Past Semester' }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    Status is automatically determined based on current date.
                                </p>
                            </div>

                            <!-- Courses Count -->
                            <div>
                                <label class="form-label">Courses in this Semester</label>
                                <p class="text-lg text-gray-900">{{ $semester->courses_count }} courses</p>
                                @if($semester->courses_count > 0)
                                    <p class="text-xs text-gray-500 mt-1">
                                        Editing dates may affect all courses in this semester.
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
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
                <div class="mt-6 card border border-red-200">
                    <div class="card-header bg-red-50 border-b border-red-200">
                        <h3 class="text-lg font-medium text-red-800">Danger Zone</h3>
                    </div>
                    <div class="card-body">
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
                <div class="mt-6 card border border-yellow-200">
                    <div class="card-header bg-yellow-50 border-b border-yellow-200">
                        <h3 class="text-lg font-medium text-yellow-800">Delete Restricted</h3>
                    </div>
                    <div class="card-body">
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
