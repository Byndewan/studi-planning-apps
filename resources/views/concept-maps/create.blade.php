<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create Concept Map</h1>
            <p class="text-gray-600 mt-1">Visualize your knowledge</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('concept-maps.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Maps
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="card">
            <div class="p-8">
                <form method="POST" action="{{ route('concept-maps.store') }}" class="space-y-6">
                    @csrf

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

                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Map Title')" />
                        <x-text-input id="title" type="text" name="title" :value="old('title')" required
                                      placeholder="e.g., Chapter 1: Introduction to Physics" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- SQ3R Sessions (Optional) -->
                    @if(isset($sq3rSessions) && $sq3rSessions->count() > 0)
                        <div>
                            <x-input-label for="sq3r_session_id" :value="__('Generate from SQ3R Session (Optional)')" />
                            <select id="sq3r_session_id" name="sq3r_session_id" class="form-input">
                                <option value="">Create empty map</option>
                                @foreach($sq3rSessions as $session)
                                    <option value="{{ $session->id }}">
                                        {{ $session->module_title }} - {{ $session->course->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Select an SQ3R session to automatically generate a concept map from your notes.</p>
                        </div>
                    @endif

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('concept-maps.index') }}" class="btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            Create Map
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
