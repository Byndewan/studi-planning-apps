<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Profil</h1>
            <p class="text-gray-600 mt-1 text-base">Perbarui informasi akun Anda</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('profile.show') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Profil
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="card card-hover">
            <div class="p-8">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Foto Profil -->
                    <div class="text-center">
                        <x-input-label value="Foto Profil" class="mb-4" />
                        <div class="flex items-center justify-center">
                            <div class="relative">
                                <img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg"
                                    src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                    alt="{{ $user->name }}">
                                <button type="button" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-camera text-sm"></i>
                                </button>
                            </div>
                        </div>
                        <input type="file" name="profile_photo" class="hidden" accept="image/*">
                        <p class="text-xs text-gray-500 mt-2">Klik ikon kamera untuk mengubah foto</p>
                    </div>

                    <!-- Informasi Dasar -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div class="group">
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="name" type="text" name="name" :value="old('name', $user->name)" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="group">
                            <x-input-label for="email" :value="__('Email')" />
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="email" type="email" name="email" :value="old('email', $user->email)" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Ganti Password -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-lock mr-2 text-gray-600"></i>
                            Ganti Password (Opsional)
                        </h3>

                        <div class="space-y-4">
                            <!-- Password Saat Ini -->
                            <div class="group">
                                <x-input-label for="current_password" :value="__('Password Saat Ini')" />
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                    <x-text-input id="current_password" type="password" name="current_password"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                        placeholder="Kosongkan jika tidak ingin mengubah password" />
                                </div>
                                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                            </div>

                            <!-- Password Baru -->
                            <div class="group">
                                <x-input-label for="password" :value="__('Password Baru')" />
                                <div class="relative">
                                    <i class="fas fa-key absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                    <x-text-input id="password" type="password" name="password"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                        placeholder="Minimal 8 karakter" />
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="group">
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                                <div class="relative">
                                    <i class="fas fa-key absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                    <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                        placeholder="Ulangi password baru" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('profile.show') }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn-primary btn-animate">
                            <span class="flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Perbarui Profil
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informasi Keamanan -->
        <div class="card card-hover">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-shield-alt mr-2 text-green-600"></i>
                    Tips Keamanan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Gunakan password yang kuat dan unik</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Jangan bagikan password dengan siapa pun</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Ganti password secara berkala</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Gunakan email yang aktif dan aman</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form validation dengan animasi
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            // Add loading state
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
            submitButton.disabled = true;

            // Re-enable button after 3 seconds (in case of error)
            setTimeout(() => {
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }, 3000);
        });

        // Real-time validation feedback
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() !== '') {
                    this.style.borderColor = '#10b981';
                    this.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.1)';
                }
            });

            input.addEventListener('focus', function() {
                this.style.borderColor = '#2563eb';
                this.style.boxShadow = '0 0 0 3px rgba(37, 99, 235, 0.1)';
            });
        });

        // Profile photo upload
        document.querySelector('button[type="button"]').addEventListener('click', function() {
            document.querySelector('input[name="profile_photo"]').click();
        });

        document.querySelector('input[name="profile_photo"]').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('img').src = e.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
</x-app-layout>
