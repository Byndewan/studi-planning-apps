<x-guest-layout>
    <!-- Header dengan animasi -->
    {{-- <div class="text-center mb-8 animate-fadeInUp">
        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h2>
        <p class="text-gray-600">Silakan masuk ke akun Anda untuk melanjutkan</p>
    </div> --}}

    <!-- Session Status dengan animasi -->
    <x-auth-session-status class="mb-6 animate-fadeInUp" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6 animate-slideInLeft">
        @csrf

        <!-- Email Address dengan animasi -->
        <div class="group">
            <x-input-label for="email" :value="__('Alamat Email')" class="text-sm font-medium text-gray-700 mb-2" />
            <div class="relative">
                <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    placeholder="nama@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password dengan animasi -->
        <div class="group">
            <x-input-label for="password" :value="__('Kata Sandi')" class="text-sm font-medium text-gray-700 mb-2" />
            <div class="relative">
                <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full pl-10 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    placeholder="••••••••" />
                <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors" onclick="togglePassword()">
                    <i class="fas fa-eye" id="toggleIcon"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me dengan animasi -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-500 font-medium transition-colors duration-200" href="{{ route('password.request') }}">
                    {{ __('Lupa Kata Sandi?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button dengan animasi -->
        <div class="pt-4">
            <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 px-4 rounded-xl font-medium hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:-translate-y-0.5 transition-all duration-200 shadow-lg hover:shadow-xl btn-animate">
                <span class="flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    {{ __('Masuk') }}
                </span>
            </button>
        </div>

        <!-- Register Link dengan animasi -->
        <div class="text-center text-sm text-gray-600">
            <p>Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 font-medium transition-colors duration-200">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </form>

    <script>
        // Toggle password visibility dengan animasi
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Add loading state to form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            submitButton.disabled = true;

            // Re-enable button after 3 seconds (in case of error)
            setTimeout(() => {
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }, 3000);
        });
    </script>
</x-guest-layout>
