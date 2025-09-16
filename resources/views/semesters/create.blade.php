<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create New Semester</h1>
            <p class="text-gray-600 mt-1">Set up a new academic semester for your courses</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('semesters.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Semesters
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="card">
            <div class="p-8">
                <form method="POST" action="{{ route('semesters.store') }}" class="space-y-6">
                    @csrf

                    <!-- Semester Name -->
                    <div>
                        <x-input-label for="name" :value="__('Semester Name')" />
                        <x-text-input id="name" type="text" name="name" :value="old('name')" required
                                      placeholder="e.g., Fall 2024, Spring 2025" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Start Date -->
                        <div>
                            <x-input-label for="start_date" :value="__('Start Date')" />
                            <x-date-picker id="start_date" name="start_date" :value="old('start_date')" required />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>

                        <!-- End Date -->
                        <div>
                            <x-input-label for="end_date" :value="__('End Date')" />
                            <x-date-picker id="end_date" name="end_date" :value="old('end_date')" required />
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Notes (Optional) -->
                    <div>
                        <x-input-label for="notes" :value="__('Notes (Optional)')" />
                        <textarea id="notes" name="notes" rows="3"
                                  class="form-input"
                                  placeholder="Any additional notes about this semester">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
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
        <div class="card">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tips for Creating a Semester</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-indigo-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Use clear naming like "Fall 2024" or "Spring 2025"
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-indigo-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Set realistic start and end dates based on your academic calendar
                        </li>
                    </ul>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-indigo-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Consider including exam periods in your date range
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-indigo-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            You can add courses after creating the semester
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
