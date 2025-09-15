<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Create New Semester') }}
        </h2>
        <div class="header-actions">
            <a href="{{ route('semesters.index') }}" class="btn-secondary">
                {{ __('Back to Semesters') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('semesters.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Semester Name -->
                            <div>
                                <label class="form-label" for="name">Semester Name *</label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
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
                                       value="{{ old('start_date') }}"
                                       required
                                       class="form-input @error('start_date') border-red-500 @enderror"
                                       x-data
                                       x-init="flatpickr($el, {dateFormat: 'Y-m-d', minDate: 'today'})">
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
                                       value="{{ old('end_date') }}"
                                       required
                                       class="form-input @error('end_date') border-red-500 @enderror"
                                       x-data
                                       x-init="flatpickr($el, {dateFormat: 'Y-m-d', minDate: 'today'})">
                                @error('end_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes (Optional) -->
                            <div>
                                <label class="form-label" for="notes">Notes (Optional)</label>
                                <textarea id="notes"
                                          name="notes"
                                          rows="3"
                                          class="form-input @error('notes') border-red-500 @enderror"
                                          placeholder="Any additional notes about this semester">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('semesters.index') }}" class="btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn-primary">
                                Create Semester
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-6 card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Tips for Creating a Semester</h3>
                </div>
                <div class="card-body">
                    <ul class="list-disc list-inside space-y-2 text-sm text-gray-600">
                        <li>Use clear naming like "Fall 2024" or "Spring 2025"</li>
                        <li>Set realistic start and end dates based on your academic calendar</li>
                        <li>Consider including exam periods in your date range</li>
                        <li>You can add courses after creating the semester</li>
                        <li>Use notes to track important semester-specific information</li>
                    </ul>
                </div>
            </div>
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
        });
    </script>
</x-app-layout>
