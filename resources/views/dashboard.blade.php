<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Welcome back, {{ auth()->user()->name }}
            </h1>
            <p class="text-gray-600 mt-1 text-sm">
                Here's your learning progress overview
            </p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Current Semester</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $currentSemester->name ?? 'None' }}</p>
                        </div>
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <x-icons.calendar class="w-6 h-6 text-indigo-600" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Active Courses</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $coursesCount }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <x-icons.book class="w-6 h-6 text-green-600" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Weekly Progress</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $completionRate }}%</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <x-icons.chart class="w-6 h-6 text-yellow-600" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $completionRate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Upcoming Tasks</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $upcomingTasks }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <x-icons.clock class="w-6 h-6 text-red-600" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Activity -->
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($recentActivities as $activity)
                            <div class="p-6 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $activity['description'] }}</p>
                                        <p class="text-xs text-gray-500 mt-2">{{ $activity['time'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                                <p class="text-gray-900 font-medium mt-4">No recent activity</p>
                                <p class="text-gray-600 text-sm mt-2">Your learning activities will appear here</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Upcoming Deadlines -->
            <div class="card mt-6">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Upcoming</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($upcomingDeadlines as $deadline)
                            <div class="p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $deadline['title'] }}</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ $deadline['course'] }}</p>
                                    </div>
                                    <span
                                        class="text-xs font-medium px-2 py-1 rounded-full {{ $deadline['urgent'] ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $deadline['date'] }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <p class="text-gray-500">No upcoming deadlines</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-6">
                <div class="card">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('sq3r.create') }}"
                            class="flex items-center p-4 rounded-xl border border-gray-200 hover:bg-gray-50 transition-all group">
                            <div
                                class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                <x-icons.book class="w-5 h-5 text-blue-600" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Start SQ3R Session</p>
                                <p class="text-xs text-gray-600 mt-1">Active reading method</p>
                            </div>
                        </a>

                        <a href="{{ route('concept-maps.create') }}"
                            class="flex items-center p-4 rounded-xl border border-gray-200 hover:bg-gray-50 transition-all group">
                            <div
                                class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                <x-icons.map class="w-5 h-5 text-green-600" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Create Concept Map</p>
                                <p class="text-xs text-gray-600 mt-1">Visualize your knowledge</p>
                            </div>
                        </a>

                        <a href="{{ route('monitorings.create') }}"
                            class="flex items-center p-4 rounded-xl border border-gray-200 hover:bg-gray-50 transition-all group">
                            <div
                                class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center group-hover:bg-yellow-200 transition-colors">
                                <x-icons.monitor class="w-5 h-5 text-yellow-600" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Log Study Session</p>
                                <p class="text-xs text-gray-600 mt-1">Track your progress</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
