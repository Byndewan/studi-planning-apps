<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Concept Map</h1>
            <p class="text-gray-600 mt-1">{{ $conceptMap->title }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('concept-maps.show', $conceptMap) }}" class="btn-secondary">
                View Map
            </a>
            <a href="{{ route('concept-maps.index') }}" class="btn-secondary">
                All Maps
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="card">
            <div class="p-8">
                <form method="POST" action="{{ route('concept-maps.update', $conceptMap) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Course Info (Read-only) -->
                    <div>
                        <x-input-label value="Course" />
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $conceptMap->course->name }}</p>
                        <p class="text-sm text-gray-600">{{ $conceptMap->course->semester->name }}</p>
                    </div>

                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Map Title')" />
                        <x-text-input id="title" type="text" name="title" :value="old('title', $conceptMap->title)"
                                      required class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('concept-maps.show', $conceptMap) }}" class="btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            Update Map
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Map Information -->
        <div class="card">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Map Information</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Created:</span>
                        <span class="text-gray-900 ml-2">{{ $conceptMap->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="text-gray-900 ml-2">{{ $conceptMap->updated_at->format('M d, Y H:i') }}</span>
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
                    Once you delete this concept map, there is no going back. Please be certain.
                </p>
                <form action="{{ route('concept-maps.destroy', $conceptMap) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this concept map? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                        Delete Map
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
