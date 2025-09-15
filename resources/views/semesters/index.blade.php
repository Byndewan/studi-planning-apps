<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Semesters') }}
        </h2>
        <div class="header-actions">
            <a href="{{ route('semesters.create') }}" class="btn-primary">
                {{ __('Add New Semester') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($semesters->isEmpty())
                <div class="card text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No semesters yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first semester.</p>
                    <div class="mt-6">
                        <a href="{{ route('semesters.create') }}" class="btn-primary">
                            {{ __('Add New Semester') }}
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($semesters as $semester)
                        <div class="card hover:shadow-lg transition-shadow duration-200">
                            <div class="card-header">
                                <h3 class="text-lg font-medium text-gray-900">{{ $semester->name }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ $semester->start_date->format('M d, Y') }} - {{ $semester->end_date->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="card-body">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-sm text-gray-600">{{ $semester->courses_count }} courses</span>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        {{ $semester->is_current ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $semester->is_current ? 'Current' : 'Past' }}
                                    </span>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('semesters.show', $semester) }}" class="btn-secondary flex-1 text-center">
                                        View
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
    </div>
</x-app-layout>
