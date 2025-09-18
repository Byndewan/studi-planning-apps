<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Sesi SQ3R</h1>
            <p class="text-gray-600 mt-1">{{ $sq3rSession->module_title }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('sq3r.show', $sq3rSession) }}" class="btn-secondary">
                <i class="fas fa-eye mr-2"></i>
                Lihat Sesi
            </a>
            <a href="{{ route('sq3r.index') }}" class="btn-secondary">
                <i class="fas fa-list mr-2"></i>
                Semua Sesi
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        <div class="card card-hover">
            <div class="p-8">
                <form method="POST" action="{{ route('sq3r.update', $sq3rSession) }}" class="space-y-8">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="course_id" value="{{ $sq3rSession->course_id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Info Mata Kuliah (Read-only) -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-blue-900">Mata Kuliah</p>
                                    <p class="text-lg font-semibold text-blue-800">{{ $sq3rSession->course->name }}</p>
                                    <p class="text-sm text-blue-600">{{ $sq3rSession->course->semester->name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Judul Modul -->
                        <div class="group">
                            <x-input-label for="module_title" :value="__('Judul Modul/Bagian')" />
                            <div class="relative">
                                <i class="fas fa-heading absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="module_title" type="text" name="module_title" :value="old('module_title', $sq3rSession->module_title)"
                                    required class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                            </div>
                            <x-input-error :messages="$errors->get('module_title')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Status Kemajuan -->
                    <div>
                        <x-input-label value="Status Kemajuan" />
                        <div class="mt-2">
                            <div class="flex items-center space-x-4">
                                @php
                                    $steps = [
                                        'survey' => [
                                            'icon' => 'S',
                                            'label' => 'Survey',
                                            'completed' => !empty($sq3rSession->survey_notes),
                                        ],
                                        'questions' => [
                                            'icon' => 'Q',
                                            'label' => 'Pertanyaan',
                                            'completed' => !empty($sq3rSession->questions),
                                        ],
                                        'read' => [
                                            'icon' => 'R',
                                            'label' => 'Baca',
                                            'completed' => !empty($sq3rSession->read_notes),
                                        ],
                                        'recite' => [
                                            'icon' => 'R',
                                            'label' => 'Ulang',
                                            'completed' => !empty($sq3rSession->recite_notes),
                                        ],
                                        'review' => [
                                            'icon' => 'R',
                                            'label' => 'Ulangi',
                                            'completed' => !empty($sq3rSession->review_notes),
                                        ],
                                    ];
                                @endphp

                                @foreach ($steps as $step)
                                    <div class="text-center">
                                        <div
                                            class="w-10 h-10 {{ $step['completed'] ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-600' }} rounded-xl flex items-center justify-center mx-auto mb-2">
                                            <span class="font-bold text-sm">{{ $step['icon'] }}</span>
                                        </div>
                                        <span
                                            class="text-xs {{ $step['completed'] ? 'text-green-600' : 'text-gray-600' }}">
                                            {{ $step['label'] }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Survey -->
                    <div class="group">
                        <x-input-label for="survey_notes" :value="__('Catatan Survey')" />
                        <textarea id="survey_notes" name="survey_notes" rows="4" class="form-input mt-1 block w-full"
                            placeholder="Apa yang Anda perhatikan saat melakukan survey?">{{ old('survey_notes', $sq3rSession->survey_notes) }}</textarea>
                        <x-input-error :messages="$errors->get('survey_notes')" class="mt-2" />
                    </div>

                    <!-- Pertanyaan -->
                    <div x-data="questionManager()" x-init="questions = {{ json_encode(old('questions', $sq3rSession->questions ?? ['', '', ''])) }}" class="space-y-4">
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
                    </div>

                    <!-- Catatan Baca -->
                    <div class="group">
                        <x-input-label for="read_notes" :value="__('Catatan Baca')" />
                        <textarea id="read_notes" name="read_notes" rows="6" class="form-input mt-1 block w-full"
                            placeholder="Apa yang Anda pelajari saat membaca? Apa jawaban yang Anda temukan untuk pertanyaan Anda?">{{ old('read_notes', $sq3rSession->read_notes) }}</textarea>
                        <x-input-error :messages="$errors->get('read_notes')" class="mt-2" />
                    </div>

                    <!-- Catatan Ulang -->
                    <div class="group">
                        <x-input-label for="recite_notes" :value="__('Catatan Ulang')" />
                        <textarea id="recite_notes" name="recite_notes" rows="4" class="form-input mt-1 block w-full"
                            placeholder="Ringkas apa yang Anda pelajari dengan kata-kata Anda sendiri...">{{ old('recite_notes', $sq3rSession->recite_notes) }}</textarea>
                        <x-input-error :messages="$errors->get('recite_notes')" class="mt-2" />
                    </div>

                    <!-- Catatan Ulangi -->
                    <div class="group">
                        <x-input-label for="review_notes" :value="__('Catatan Ulangi')" />
                        <textarea id="review_notes" name="review_notes" rows="4" class="form-input mt-1 block w-full"
                            placeholder="Apa poin-poin penting yang harus Anda ingat? Apa yang perlu diulang?">{{ old('review_notes', $sq3rSession->review_notes) }}</textarea>
                        <x-input-error :messages="$errors->get('review_notes')" class="mt-2" />
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('sq3r.show', $sq3rSession) }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn-primary btn-animate">
                            <span class="flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Perbarui Sesi
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informasi Sesi -->
        <div class="card card-hover">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informasi Sesi
                </h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Dibuat</span>
                        <span class="font-medium text-gray-900">{{ $sq3rSession->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Diperbarui</span>
                        <span class="font-medium text-gray-900">{{ $sq3rSession->updated_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Status</span>
                        <span
                            class="px-2 py-1 text-xs font-medium rounded-full {{ $sq3rSession->review_notes ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $sq3rSession->review_notes ? 'Selesai' : 'Dalam Proses' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zona Bahaya -->
        <div class="card card-hover border border-red-200">
            <div class="p-6 bg-red-50 border-b border-red-200">
                <h3 class="text-lg font-semibold text-red-800 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Zona Bahaya
                </h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">
                    Setelah Anda menghapus sesi SQ3R ini, tidak akan bisa dikembalikan. Harap berhati-hati.
                </p>
                <form action="{{ route('sq3r.destroy', $sq3rSession) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi SQ3R ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Sesi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Form validation dengan animasi
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            // Add loading state
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui...';
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
