<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Monitoring Entry</h1>
            <p class="text-gray-600 mt-1">{{ $monitoring->date->format('M d, Y') }} - {{ $monitoring->course->name }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('monitorings.edit', $monitoring) }}" class="btn-secondary">
                Edit Entry
            </a>
            <a href="{{ route('courses.show', $monitoring->course) }}" class="btn-secondary">
                Back to Course
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <div class="card">
            <div class="p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $monitoring->course->name }}</h2>
                        <p class="text-gray-600 mt-1">
                            Week {{ $monitoring->week_number }} • {{ $monitoring->date->format('M d, Y') }}
                        </p>
                    </div>
                    <span class="status-badge {{ $monitoring->achieved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $monitoring->achieved ? 'Achieved' : 'Not Achieved' }}
                    </span>
                </div>

                <!-- Study Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-sm font-medium text-gray-600 mb-3">Planned Activities</h3>
                        <p class="text-gray-900">{{ $monitoring->planned }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-sm font-medium text-gray-600 mb-3">Actual Activities</h3>
                        <p class="text-gray-900">{{ $monitoring->actual }}</p>
                    </div>
                </div>

                <!-- Analysis -->
                @if($monitoring->cause || $monitoring->solution)
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Analysis</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($monitoring->cause)
                                <div class="bg-yellow-50 rounded-xl p-6 border border-yellow-200">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Cause of Variance</h4>
                                    <p class="text-gray-900">{{ $monitoring->cause }}</p>
                                </div>
                            @endif
                            @if($monitoring->solution)
                                <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Proposed Solution</h4>
                                    <p class="text-gray-900">{{ $monitoring->solution }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Course Context -->
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-4">Course Context</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Semester:</span>
                            <span class="ml-2 text-gray-900">{{ $monitoring->course->semester->name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Course Code:</span>
                            <span class="ml-2 text-gray-900">{{ $monitoring->course->code }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">SKS:</span>
                            <span class="ml-2 text-gray-900">{{ $monitoring->course->sks }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Total Modules:</span>
                            <span class="ml-2 text-gray-900">{{ $monitoring->course->total_modules }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="border-t border-gray-200 pt-6 mt-6 flex justify-end space-x-3">
                    <a href="{{ route('monitorings.edit', $monitoring) }}" class="btn-secondary">
                        Edit Entry
                    </a>
                    <form action="{{ route('monitorings.destroy', $monitoring) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this monitoring entry?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
