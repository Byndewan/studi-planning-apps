<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $semester->name }}
        </h2>
        <div class="header-actions space-x-2">
            <a href="{{ route('semesters.edit', $semester) }}" class="btn-secondary">
                Edit
            </a>
            <form action="{{ route('semesters.generate-schedule', $semester) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-primary"
                    onclick="return confirm('Generate schedule for all courses? This will create weekly plans for weeks 1-14.')">
                    Generate Schedule
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Semester Info -->
            <div class="card mb-6">
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Duration</h4>
                            <p class="text-lg text-gray-900">
                                {{ $semester->start_date->format('M d, Y') }} - {{ $semester->end_date->format('M d, Y') }}
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Total Courses</h4>
                            <p class="text-lg text-gray-900">{{ $semester->courses->count() }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Status</h4>
                            <span class="px-3 py-1 text-sm font-medium rounded-full
                                {{ $semester->is_current ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $semester->is_current ? 'Current' : 'Past' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses Section -->
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Courses</h3>
                    <a href="{{ route('courses.create') }}?semester_id={{ $semester->id }}" class="btn-primary text-sm">
                        Add Course
                    </a>
                </div>
                <div class="card-body">
                    @if($semester->courses->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p class="mt-2">No courses yet</p>
                            <a href="{{ route('courses.create') }}?semester_id={{ $semester->id }}" class="btn-primary mt-4 inline-block">
                                Add Your First Course
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKS</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modules</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($semester->courses as $course)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $course->code }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $course->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $course->sks }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $course->total_modules }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                                <a href="{{ route('courses.edit', $course) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
