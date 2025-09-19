<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Catat Sesi Belajar</h1>
            <p class="text-gray-600 mt-1 text-base">Lacak kemajuan belajar Anda dan identifikasi area untuk perbaikan</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('monitorings.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Monitoring
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="card card-hover">
            <div class="p-8">
                <form method="POST" action="{{ route('monitorings.store') }}" class="space-y-8">
                    @csrf

                    <!-- Pemilihan Mata Kuliah -->
                    <div class="group">
                        <x-input-label for="course_id" :value="__('Mata Kuliah')" />
                        <div class="relative">
                            <i class="fas fa-book absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <select id="course_id" name="course_id" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">Pilih mata kuliah</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }} ({{ $course->semester->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal -->
                        <div class="group">
                            <x-input-label for="date" :value="__('Tanggal')" />
                            <div class="relative">
                                <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-date-picker name="date" :value="old('date', now()->format('Y-m-d'))" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                            </div>
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <!-- Nomor Minggu -->
                        <div class="group">
                            <x-input-label for="week_number" :value="__('Nomor Minggu')" />
                            <div class="relative">
                                <i class="fas fa-calendar-week absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <select id="week_number" name="week_number" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                    <option value="">Pilih nomor minggu</option>
                                    @for($i = 1; $i <= 14; $i++)
                                        <option value="{{ $i }}" {{ old('week_number') == $i ? 'selected' : '' }}>
                                            Minggu {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('week_number')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Kegiatan yang Direncanakan -->
                    <div class="group">
                        <x-input-label for="planned" :value="__('Kegiatan yang Direncanakan')" />
                        <textarea id="planned" name="planned" rows="4" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Apa yang Anda rencanakan untuk dipelajari?">{{ old('planned') }}</textarea>
                        <x-input-error :messages="$errors->get('planned')" class="mt-2" />
                    </div>

                    <!-- Kegiatan yang Dilakukan -->
                    <div class="group">
                        <x-input-label for="actual" :value="__('Kegiatan yang Dilakukan')" />
                        <textarea id="actual" name="actual" rows="4" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Apa yang benar-benar Anda capai?">{{ old('actual') }}</textarea>
                        <x-input-error :messages="$errors->get('actual')" class="mt-2" />
                    </div>

                    <!-- Penyebab Perbedaan -->
                    <div class="group">
                        <x-input-label for="cause" :value="__('Penyebab Perbedaan')" />
                        <textarea id="cause" name="cause" rows="3"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Mengapa ada perbedaan antara yang direncanakan dan yang dilakukan?">{{ old('cause') }}</textarea>
                        <x-input-error :messages="$errors->get('cause')" class="mt-2" />
                    </div>

                    <!-- Solusi -->
                    <div class="group">
                        <x-input-label for="solution" :value="__('Solusi/Perbaikan')" />
                        <textarea id="solution" name="solution" rows="3"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Bagaimana Anda bisa memperbaikinya untuk lain kali?">{{ old('solution') }}</textarea>
                        <x-input-error :messages="$errors->get('solution')" class="mt-2" />
                    </div>

                    <!-- Tercapai -->
                    <div class="flex items-center">
                        <input type="checkbox" id="achieved" name="achieved" value="1" {{ old('achieved') ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-4 w-4">
                        <x-input-label for="achieved" :value="__('Tandai sebagai tercapai')" class="ml-3 mb-0 text-gray-700" />
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('monitorings.index') }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn-primary btn-animate">
                            <span class="flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Catat Sesi
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Manfaat Monitoring -->
        <div class="card card-hover mt-8">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-green-600"></i>
                    Mengapa Memantau Belajar Anda?
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <ul class="space-y-4 text-sm text-gray-600">
                        <li class="flex items-start">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span class="ml-3">Mengidentifikasi pola dalam kebiasaan belajar Anda</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span class="ml-3">Membantu memahami apa yang berhasil dan tidak berhasil</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span class="ml-3">Memberikan data untuk membuat rencana studi yang lebih baik</span>
                        </li>
                    </ul>
                    <ul class="space-y-4 text-sm text-gray-600">
                        <li class="flex items-start">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span class="ml-3">Meningkatkan akuntabilitas dan motivasi</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span class="ml-3">Membantu melacak kemajuan dari waktu ke waktu</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span class="ml-3">Mengungkapkan masalah manajemen waktu lebih awal</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
            submitButton.disabled = true;
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
    </script>
</x-app-layout>
