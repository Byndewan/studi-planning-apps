<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Profile') }}
        </h2>
        <div class="header-actions">
            <a href="{{ route('profile.edit') }}" class="btn-primary">
                {{ __('Edit Profile') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center space-x-6 mb-8">
                        <div class="flex-shrink-0">
                            <img class="h-20 w-20 rounded-full object-cover"
                                 src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name= ' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                 alt="{{ $user->name }}">
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                Member since {{ $user->created_at->format('F Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Current Semester:</span>
                            <span class="ml-2 text-gray-900">{{ $user->currentSemester->name ?? 'None' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Total Courses:</span>
                            <span class="ml-2 text-gray-900">{{ $user->courses_count ?? 0 }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Completed Plans:</span>
                            <span class="ml-2 text-gray-900">{{ $user->completed_plans_count ?? 0 }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Study Sessions:</span>
                            <span class="ml-2 text-gray-900">{{ $user->study_sessions_count ?? 0 }}</span>
                        </div>
                    </div>

                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>

                        <div class="space-y-3">
                            @if($recentActivities->count() > 0)
                                @foreach($recentActivities as $activity)
                                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <x-dynamic-component
                                                    :component="'icons.' . $activity['icon']"
                                                    class="w-4 h-4 text-blue-600" />
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900">{{ $activity['description'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500 text-center py-4">No recent activity</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
