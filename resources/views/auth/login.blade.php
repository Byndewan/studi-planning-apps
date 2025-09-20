<x-guest-layout>
    <!-- Session Status dengan animasi -->
    <x-auth-session-status class="mb-6 animate-fadeInUp" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6 animate-slideInLeft">
        @csrf

        <!-- Email Address dengan animasi -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="text-sm font-medium text-gray-700 mb-2" />
            <div class="relative group">
                <i
                    class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2
   text-gray-400 group-focus-within:text-blue-600 transition-colors
   pointer-events-none z-10"></i>
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    placeholder="nama@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password dengan animasi -->
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" class="text-sm font-medium text-gray-700 mb-2" />
            <div class="relative group">
                <i
                    class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2
   text-gray-400 group-focus-within:text-blue-600 transition-colors
   pointer-events-none z-10"></i>
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full pl-10 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    placeholder="••••••••" />
                <button type="button"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                    onclick="togglePassword()">
                    <i class="fas fa-eye" id="toggleIcon"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Submit Button dengan animasi -->
        <div class="pt-4">
            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-2 px-4 rounded-full font-medium hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:-translate-y-0.5 transition-all duration-200 shadow-lg hover:shadow-xl btn-animate">
                <span class="flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    {{ __('Masuk') }}
                </span>
            </button>
        </div>

    </form>

    <script>
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

        document.querySelector('form').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            submitButton.disabled = true;

            setTimeout(() => {
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }, 3000);
        });
    </script>
</x-guest-layout>
