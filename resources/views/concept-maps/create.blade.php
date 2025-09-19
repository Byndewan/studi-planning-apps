<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Buat Peta Konsep Baru</h1>
            <p class="text-gray-600 mt-1 text-base">Visualisasikan pengetahuan Anda</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('concept-maps.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Peta Konsep
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="card card-hover">
            <div class="p-8">
                <form method="POST" action="{{ route('concept-maps.store') }}" class="space-y-8">
                    @csrf

                    <!-- Pemilihan Mata Kuliah -->
                    <div class="group">
                        <x-input-label for="course_id" :value="__('Mata Kuliah')" />
                        <div class="relative">
                            <i class="fas fa-book absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <select id="course_id" name="course_id" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach(auth()->user()->courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }} ({{ $course->semester->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                    </div>

                    <!-- Judul Peta Konsep -->
                    <div class="group">
                        <x-input-label for="title" :value="__('Judul Peta Konsep')" />
                        <div class="relative">
                            <i class="fas fa-heading absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <x-text-input id="title" type="text" name="title" :value="old('title')" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="Contoh: Bab 1: Pengantar Fisika" />
                        </div>
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Sesi SQ3R (Opsional) -->
                    @if(isset($sq3rSessions) && $sq3rSessions->count() > 0)
                        <div class="group">
                            <x-input-label for="sq3r_session_id" :value="__('Hasilkan dari Sesi SQ3R (Opsional)')" />
                            <div class="relative">
                                <i class="fas fa-sync-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <select id="sq3r_session_id" name="sq3r_session_id"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                    @foreach($sq3rSessions as $session)
                                        <option value="{{ $session->id }}">
                                            {{ $session->module_title }} - {{ $session->course->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Pilih sesi SQ3R untuk membuat peta konsep secara otomatis dari catatan Anda.</p>
                        </div>
                    @endif

                    <!-- Tombol Aksi -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('concept-maps.index') }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn-primary btn-animate">
                            <span class="flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Buat Peta Konsep
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informasi Manfaat -->
        <div class="card card-hover mt-8">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-lightbulb mr-2 text-yellow-600"></i>
                    Manfaat Peta Konsep
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Membantu memahami hubungan antar konsep</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Meningkatkan daya ingat dan retensi informasi</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Memudahkan review materi secara visual</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Mengidentifikasi konsep utama dan pendukung</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Membuat...';
            submitButton.disabled = true;

            setTimeout(() => {
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }, 3000);
        });

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
    </script>
</x-app-layout>
