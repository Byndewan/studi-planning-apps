<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Semesters</h1>
            <p class="text-gray-600 mt-1">Manage your academic semesters</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('semesters.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Semester
            </a>
        </x-slot>
    </x-slot>

    <div class="space-y-6">
        @if($semesters->isEmpty())
            <div class="card">
                <div class="empty-state">
                    <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <x-icons.calendar class="w-8 h-8 text-gray-400" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No semesters yet</h3>
                    <p class="text-gray-600 mt-2">Get started by creating your first semester.</p>
                    <a href="{{ route('semesters.create') }}" class="btn-primary mt-6">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Semester
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($semesters as $semester)
                    <div class="card hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $semester->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $semester->start_date->format('M d, Y') }} - {{ $semester->end_date->format('M d, Y') }}
                                    </p>
                                </div>
                                <span class="status-badge {{ $semester->is_current ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $semester->is_current ? 'Current' : 'Past' }}
                                </span>
                            </div>

                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Courses</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $semester->courses->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Duration</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $semester->start_date->diffInWeeks($semester->end_date) }} weeks</span>
                                </div>
                            </div>

                            <div class="mt-6 flex space-x-2">
                                <a href="{{ route('semesters.show', $semester) }}" class="btn-secondary flex-1 text-center">
                                    View Details
                                </a>
                                <a href="{{ route('semesters.edit', $semester) }}" class="btn-secondary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
