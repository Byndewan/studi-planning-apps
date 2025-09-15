<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Monitoring Entry - {{ $monitoring->date->format('M d, Y') }}
        </h2>
        <div class="header-actions space-x-2">
            <a href="{{ route('monitorings.edit', $monitoring) }}" class="btn-secondary">
                Edit
            </a>
            <a href="{{ route('courses.show', $monitoring->course) }}" class="btn-secondary">
                Back to Course
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $monitoring->course->name }}</h3>
                        <p class="text-sm text-gray-500">
                            Week {{ $monitoring->week_number }} • {{ $monitoring->date->format('M d, Y') }}
                        </p>
                    </div>
                    <span class="px-3 py-1 text-sm font-medium rounded-full
                        {{ $monitoring->achieved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $monitoring->achieved ? 'Achieved' : 'Not Achieved' }}
                    </span>
                </div>

                <div class="card-body space-y-6">
                    <!-- Study Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Planned Activities</h4>
                            <p class="mt-1 text-gray-900">{{ $monitoring->planned }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Actual Activities</h4>
                            <p class="mt-1 text-gray-900">{{ $monitoring->actual }}</p>
                        </div>
                    </div>

                    <!-- Analysis -->
                    @if($monitoring->cause || $monitoring->solution)
                        <div class="border-t pt-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Analysis</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if($monitoring->cause)
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-500">Cause of Variance</h5>
                                        <p class="mt-1 text-gray-900">{{ $monitoring->cause }}</p>
                                    </div>
                                @endif
                                @if($monitoring->solution)
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-500">Proposed Solution</h5>
                                        <p class="mt-1 text-gray-900">{{ $monitoring->solution }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Course Context -->
                    <div class="border-t pt-6">
                        <h4 class="text-sm font-medium text-gray-500">Course Context</h4>
                        <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Semester:</span>
                                <span class="ml-2 text-gray-900">{{ $monitoring->course->semester->name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Course Code:</span>
                                <span class="ml-2 text-gray-900">{{ $monitoring->course->code }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">SKS:</span>
                                <span class="ml-2 text-gray-900">{{ $monitoring->course->sks }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Total Modules:</span>
                                <span class="ml-2 text-gray-900">{{ $monitoring->course->total_modules }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="border-t pt-6 flex justify-end space-x-3">
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
    </div>
</x-app-layout>
