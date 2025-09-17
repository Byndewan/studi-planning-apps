<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Edit Profile') }}
        </h2>
        <div class="header-actions">
            <a href="{{ route('profile.show') }}" class="btn-secondary">
                {{ __('Back to Profile') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <!-- Profile Photo -->
                                <label class="form-label text-center">Profile Photo</label>
                                <div class="flex items-center space-x-6 justify-center">
                                    <div class="flex-shrink-0">
                                        <img class="h-20 w-20 rounded-full object-cover"
                                            src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name= ' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                            alt="{{ $user->name }}">
                                    </div>
                                </div>

                            </div>

                            <!-- Name -->
                            <div>
                                <label class="form-label" for="name">Full Name</label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" required
                                    class="form-input @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email', $user->email) }}" required
                                    class="form-input @error('email') border-red-500 @enderror" autocomplete="username">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Current Password -->
                            <div>
                                <label class="form-label" for="current_password">Current Password</label>
                                <input type="password" id="current_password" name="current_password"
                                    class="form-input @error('current_password') border-red-500 @enderror"
                                    placeholder="Enter current password to change it">
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label class="form-label" for="password">New Password</label>
                                <input type="password" id="password" name="password"
                                    class="form-input @error('password') border-red-500 @enderror"
                                    placeholder="Enter new password">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Confirm Password -->
                            <div>
                                <label class="form-label" for="password_confirmation">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-input" placeholder="Confirm new password">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('profile.show') }}" class="btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn-primary">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
