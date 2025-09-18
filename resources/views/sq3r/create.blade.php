<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Sesi SQ3R Baru</h1>
            <p class="text-gray-600 mt-1">Mulai sesi membaca aktif menggunakan metode SQ3R</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('sq3r.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Sesi
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="card card-hover">
            <div class="p-8">
                <form method="POST" action="{{ route('sq3r.store') }}" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pemilihan Mata Kuliah -->
                        <div class="group">
                            <x-input-label for="course_id" :value="__('Mata Kuliah')" />
                            <div class="relative">
                                <i class="fas fa-book absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <select id="course_id" name="course_id" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                    <option value="">Pilih mata kuliah</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>
                                            {{ $course->name }} ({{ $course->semester->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                        </div>

                        <!-- Judul Modul -->
                        <div class="group">
                            <x-input-label for="module_title" :value="__('Judul Modul/Bagian')" />
                            <div class="relative">
                                <i class="fas fa-heading absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="module_title" type="text" name="module_title" :value="old('module_title')"
                                    required class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="Contoh: Bab 1: Pengantar Fisika" />
                            </div>
                            <x-input-error :messages="$errors->get('module_title')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Catatan Survey -->
                    <div class="group">
                        <x-input-label for="survey_notes" :value="__('Catatan Survey')" />
                        <textarea id="survey_notes" name="survey_notes" rows="4"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Tinjau judul, subjudul, gambar, dan ringkasan. Catat ide utama dan struktur...">{{ old('survey_notes') }}</textarea>
                        <x-input-error :messages="$errors->get('survey_notes')" class="mt-2" />
                        <p class="text-xs text-gray-500 mt-1">Tinjau materi terlebih dahulu untuk mendapatkan gambaran umum.</p>
                    </div>

                    <!-- Pertanyaan -->
                    <div x-data="questionManager()" class="space-y-4">
                        <x-input-label value="Pertanyaan" />

                        <template x-for="(question, index) in questions" :key="'question-' + index">
                            <div class="mb-3 flex items-center space-x-2">
                                <span
                                    class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-medium text-blue-600"
                                    x-text="index + 1"></span>
                                <input type="text" :name="'questions[' + index + ']'" x-model="questions[index]"
                                    class="form-input flex-1" :placeholder="'Pertanyaan ' + (index + 1)" />
                                <button type="button" @click="removeQuestion(index)" x-show="questions.length > 1"
                                    class="text-red-500 hover:text-red-700 text-sm px-2 py-1">
                                    ✕
                                </button>
                            </div>
                        </template>

                        <div class="flex space-x-2 mt-2">
                            <button type="button" @click="addQuestion"
                                class="flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Pertanyaan
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('questions')" class="mt-2" />
                        <p class="text-xs text-gray-500 mt-1">Ubah judul menjadi pertanyaan untuk memandu pembacaan Anda.</p>
                    </div>

                    <!-- Catatan Baca -->
                    <div class="group">
                        <x-input-label for="read_notes" :value="__('Catatan Baca')" />
                        <textarea id="read_notes" name="read_notes" rows="5"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Apa yang Anda pelajari saat membaca? Apa jawaban yang Anda temukan untuk pertanyaan Anda?">{{ old('read_notes') }}</textarea>
                        <x-input-error :messages="$errors->get('read_notes')" class="mt-2" />
                        <p class="text-xs text-gray-500 mt-1">Baca secara aktif sambil mencari jawaban untuk pertanyaan Anda.</p>
                    </div>

                    <!-- Catatan Ulang -->
                    <div class="group">
                        <x-input-label for="recite_notes" :value="__('Catatan Ulang')" />
                        <textarea id="recite_notes" name="recite_notes" rows="4"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Ringkas apa yang Anda pelajari dengan kata-kata Anda sendiri...">{{ old('recite_notes') }}</textarea>
                        <x-input-error :messages="$errors->get('recite_notes')" class="mt-2" />
                    </div>

                    <!-- Catatan Ulangi -->
                    <div class="group">
                        <x-input-label for="review_notes" :value="__('Catatan Ulangi')" />
                        <textarea id="review_notes" name="review_notes" rows="4"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Apa poin-poin penting yang harus Anda ingat? Apa yang perlu diulang?">{{ old('review_notes') }}</textarea>
                        <x-input-error :messages="$errors->get('review_notes')" class="mt-2" />
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('sq3r.index') }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn-primary btn-animate">
                            <span class="flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Mulai Sesi SQ3R
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Penjelasan Metode SQ3R -->
        <div class="card card-hover mt-8">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Tentang Metode SQ3R
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 text-center">
                    <div class="p-4 bg-blue-50 rounded-xl border border-blue-200 hover:shadow-md transition-all duration-200">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center mx-auto mb-3">
                            <span class="font-bold">S</span>
                        </div>
                        <p class="font-medium text-gray-900">Survey</p>
                        <p class="text-xs text-gray-600 mt-1">Tinjau materi terlebih dahulu</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-xl border border-green-200 hover:shadow-md transition-all duration-200">
                        <div class="w-10 h-10 bg-green-600 text-white rounded-xl flex items-center justify-center mx-auto mb-3">
                            <span class="font-bold">Q</span>
                        </div>
                        <p class="font-medium text-gray-900">Question</p>
                        <p class="text-xs text-gray-600 mt-1">Buat pertanyaan</p>
                    </div>
                    <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-200 hover:shadow-md transition-all duration-200">
                        <div class="w-10 h-10 bg-yellow-600 text-white rounded-xl flex items-center justify-center mx-auto mb-3">
                            <span class="font-bold">R</span>
                        </div>
                        <p class="font-medium text-gray-900">Read</p>
                        <p class="text-xs text-gray-600 mt-1">Baca secara aktif</p>
                    </div>
                    <div class="p-4 bg-purple-50 rounded-xl border border-purple-200 hover:shadow-md transition-all duration-200">
                        <div class="w-10 h-10 bg-purple-600 text-white rounded-xl flex items-center justify-center mx-auto mb-3">
                            <span class="font-bold">R</span>
                        </div>
                        <p class="font-medium text-gray-900">Recite</p>
                        <p class="text-xs text-gray-600 mt-1">Ulang dengan kata sendiri</p>
                    </div>
                    <div class="p-4 bg-red-50 rounded-xl border border-red-200 hover:shadow-md transition-all duration-200">
                        <div class="w-10 h-10 bg-red-600 text-white rounded-xl flex items-center justify-center mx-auto mb-3">
                            <span class="font-bold">R</span>
                        </div>
                        <p class="font-medium text-gray-900">Review</p>
                        <p class="text-xs text-gray-600 mt-1">Ulangi untuk memperkuat</p>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                    <h4 class="font-medium text-gray-900 mb-2 flex items-center">
                        <i class="fas fa-star mr-2 text-yellow-500"></i>
                        Mengapa SQ3R Efektif:
                    </h4>
                    <ul class="list-disc list-inside space-y-1 text-sm text-gray-600">
                        <li>Meningkatkan pemahaman dan retensi informasi</li>
                        <li>Membantu mengidentifikasi konsep utama</li>
                        <li>Membuat membaca lebih aktif dan menarik</li>
                        <li>Memberikan pendekatan terstruktur untuk belajar</li>
                        <li>Menciptakan bahan studi yang siap pakai</li>
                    </ul>
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
    </script>
</x-app-layout>
