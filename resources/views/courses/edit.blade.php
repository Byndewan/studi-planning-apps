<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Course</h1>
            <p class="text-gray-600 mt-1">{{ $course->code }} - {{ $course->name }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('courses.show', $course) }}" class="btn-secondary">
                View Course
            </a>
            <a href="{{ route('courses.index') }}" class="btn-secondary">
                All Courses
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="card">
            <div class="p-8">
                <form method="POST" action="{{ route('courses.update', $course) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Semester Selection -->
                    <div>
                        <x-input-label for="semester_id" :value="__('Semester')" />
                        <select id="semester_id" name="semester_id" required class="form-input mt-1 block w-full">
                            <option value="">Select a semester</option>
                            @foreach(auth()->user()->semesters as $semester)
                                <option value="{{ $semester->id }}" {{ old('semester_id', $course->semester_id) == $semester->id ? 'selected' : '' }}>
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
                            <x-text-input id="code" type="text" name="code" :value="old('code', $course->code)" required
                                          class="uppercase" />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>

                        <!-- Course Name -->
                        <div>
                            <x-input-label for="name" :value="__('Course Name')" />
                            <x-text-input id="name" type="text" name="name" :value="old('name', $course->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- SKS (Credits) -->
                        <div>
                            <x-input-label for="sks" :value="__('SKS (Credits)')" />
                            <x-text-input id="sks" type="number" name="sks" :value="old('sks', $course->sks)" required
                                          min="1" max="6" />
                            <x-input-error :messages="$errors->get('sks')" class="mt-2" />
                        </div>

                        <!-- Total Modules -->
                        <div>
                            <x-input-label for="total_modules" :value="__('Total Modules')" />
                            <x-text-input id="total_modules" type="number" name="total_modules"
                                          :value="old('total_modules', $course->total_modules)" min="0" />
                            <x-input-error :messages="$errors->get('total_modules')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <x-input-label for="notes" :value="__('Notes (Optional)')" />
                        <textarea id="notes" name="notes" rows="3" class="form-input mt-1 block w-full">{{ old('notes', $course->notes) }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('courses.show', $course) }}" class="btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            Update Course
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Course Information -->
        <div class="card">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Information</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Created:</span>
                        <span class="text-gray-900 ml-2">{{ $course->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="text-gray-900 ml-2">{{ $course->updated_at->format('M d, Y H:i') }}</span>
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
                    Once you delete this course, all associated data (weekly plans, monitoring entries, SQ3R sessions, and concept maps) will also be deleted. Please be certain.
                </p>
                <form action="{{ route('courses.destroy', $course) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this course? This action cannot be undone and will delete all associated data.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                        Delete Course
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
