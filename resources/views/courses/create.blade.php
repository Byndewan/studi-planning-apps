<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create Course</h1>
            <p class="text-gray-600 mt-1">Add a new course to your semester</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('courses.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Courses
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="card">
            <div class="p-8">
                <form method="POST" action="{{ route('courses.store') }}" class="space-y-6">
                    @csrf

                    <!-- Semester Selection -->
                    <div>
                        <x-input-label for="semester_id" :value="__('Semester')" />
                        <select id="semester_id" name="semester_id" required
                                class="form-input @error('semester_id') border-red-500 @enderror">
                            <option value="">Select a semester</option>
                            @foreach(auth()->user()->semesters as $semester)
                                <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->name }} ({{ $semester->period }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('semester_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Course Code -->
                        <div>
                            <x-input-label for="code" :value="__('Course Code')" />
                            <x-text-input id="code" type="text" name="code" :value="old('code')" required
                                          placeholder="e.g., IF101" class="uppercase" />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>

                        <!-- Course Name -->
                        <div>
                            <x-input-label for="name" :value="__('Course Name')" />
                            <x-text-input id="name" type="text" name="name" :value="old('name')" required
                                          placeholder="e.g., Introduction to Programming" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- SKS (Credits) -->
                        <div>
                            <x-input-label for="sks" :value="__('SKS (Credits)')" />
                            <x-text-input id="sks" type="number" name="sks" :value="old('sks')" required
                                          min="1" max="6" />
                            <x-input-error :messages="$errors->get('sks')" class="mt-2" />
                        </div>

                        <!-- Total Modules -->
                        <div>
                            <x-input-label for="total_modules" :value="__('Total Modules')" />
                            <x-text-input id="total_modules" type="number" name="total_modules" :value="old('total_modules')"
                                          min="0" placeholder="Optional" />
                            <x-input-error :messages="$errors->get('total_modules')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <x-input-label for="notes" :value="__('Notes (Optional)')" />
                        <textarea id="notes" name="notes" rows="3"
                                  class="form-input @error('notes') border-red-500 @enderror"
                                  placeholder="Additional information about the course...">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('courses.index') }}" class="btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            Create Course
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Course Information -->
        <div class="card mt-6">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">About Course Creation</h3>
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Organize your courses by semester for better tracking</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Use consistent course codes for easy identification</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Set total modules to help plan your weekly study schedule</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
