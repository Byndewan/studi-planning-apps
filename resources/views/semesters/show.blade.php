<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $semester->name }}</h1>
            <p class="text-gray-600 mt-1">{{ $semester->start_date->format('M d, Y') }} - {{ $semester->end_date->format('M d, Y') }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('semesters.edit', $semester) }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <form action="{{ route('semesters.generate-schedule', $semester) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-primary"
                    onclick="return confirm('Generate schedule for all courses? This will create weekly plans for weeks 1-14.')">
                    Generate Schedule
                </button>
            </form>
        </x-slot>
    </x-slot>

    <div class="space-y-6">
        <!-- Semester Info -->
        <div class="card">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Duration</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">
                            {{ $semester->start_date->format('M d, Y') }} - {{ $semester->end_date->format('M d, Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Courses</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $semester->courses->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <span class="status-badge {{ $semester->is_current ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $semester->is_current ? 'Current Semester' : 'Past Semester' }}
                        </span>
                    </div>
                </div>

                @if($semester->notes)
                    <div class="mt-6">
                        <p class="text-sm font-medium text-gray-600">Notes</p>
                        <p class="text-gray-900 mt-2">{{ $semester->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Courses Section -->
        <div class="card">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Courses</h2>
                    <a href="{{ route('courses.create') }}?semester_id={{ $semester->id }}" class="btn-primary text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Course
                    </a>
                </div>
            </div>

            @if($semester->courses->isEmpty())
                <div class="empty-state">
                    <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <x-icons.book class="w-8 h-8 text-gray-400" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No courses yet</h3>
                    <p class="text-gray-600 mt-2">Add courses to this semester to get started.</p>
                    <a href="{{ route('courses.create') }}?semester_id={{ $semester->id }}" class="btn-primary mt-6">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Course
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>SKS</th>
                                <th>Modules</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semester->courses as $course)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-medium text-gray-900">{{ $course->code }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $course->name }}</p>
                                        @if($course->notes)
                                            <p class="text-xs text-gray-500 mt-1">{{ Str::limit($course->notes, 50) }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-900">{{ $course->sks }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-900">{{ $course->total_modules }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('courses.show', $course) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                View
                                            </a>
                                            <a href="{{ route('courses.edit', $course) }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
