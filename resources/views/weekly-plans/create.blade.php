<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Buat Rencana Mingguan</h1>
            <p class="text-gray-600 mt-1 text-base">Rencanakan jadwal belajar Anda untuk minggu ini</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('weekly-plans.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Rencana
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="card card-hover">
            <div class="p-8">
                <form method="POST" action="{{ route('weekly-plans.store') }}" class="space-y-8">
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
                                    @foreach(auth()->user()->courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>
                                            {{ $course->name }} ({{ $course->semester->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                        </div>

                        <!-- Nomor Minggu -->
                        <div class="group">
                            <x-input-label for="week_number" :value="__('Nomor Minggu')" />
                            <div class="relative">
                                <i class="fas fa-calendar-week absolute right-5 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <select id="week_number" name="week_number" required
                                    class="form-inpu w-full pl-3 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-whitet">
                                    <option value="">Pilih minggu</option>
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

                    <!-- Target Pembelajaran -->
                    <div class="group">
                        <x-input-label for="target_text" :value="__('Target Pembelajaran')" />
                        <textarea id="target_text" name="target_text" rows="4" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Apa yang ingin Anda pelajari minggu ini?">{{ old('target_text') }}</textarea>
                        <x-input-error :messages="$errors->get('target_text')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Jam yang Direncanakan -->
                        <div class="group">
                            <x-input-label for="planned_hours" :value="__('Jam yang Direncanakan')" />
                            <div class="relative">
                                <i class="fas fa-clock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="planned_hours" type="number" name="planned_hours" :value="old('planned_hours')"
                                    min="0" step="0.5" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                            </div>
                            <x-input-error :messages="$errors->get('planned_hours')" class="mt-2" />
                        </div>

                        <!-- Jumlah Halaman -->
                        <div class="group">
                            <x-input-label for="num_pages" :value="__('Jumlah Halaman')" />
                            <div class="relative">
                                <i class="fas fa-file-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="num_pages" type="number" name="num_pages" :value="old('num_pages')"
                                    min="0" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                            </div>
                            <x-input-error :messages="$errors->get('num_pages')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="group">
                            <x-input-label for="status" :value="__('Status')" />
                            <div class="relative">
                                <i class="fas fa-flag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <select id="status" name="status" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                    <option value="planned" {{ old('status') == 'planned' ? 'selected' : '' }}>Direncanakan</option>
                                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="missed" {{ old('status') == 'missed' ? 'selected' : '' }}>Terlewat</option>
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Sumber Media -->
                    <div class="group">
                        <x-input-label for="media" :value="__('Sumber Media (Opsional)')" />
                        <textarea id="media" name="media" rows="3"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Masukkan URL atau deskripsi sumber media (satu per baris)">{{ old('media', is_array($weeklyPlan->media) ? implode("\n", $weeklyPlan->media) : '') }}</textarea>
                        <x-input-error :messages="$errors->get('media')" class="mt-2" />
                        <p class="text-xs text-gray-500 mt-1">Contoh: Link video YouTube, PDF, atau sumber online lainnya</p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('weekly-plans.index') }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn-primary btn-animate">
                            <span class="flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Buat Rencana
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tips Sukses -->
        <div class="card card-hover mt-8">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-lightbulb mr-2 text-yellow-600"></i>
                    Tips Rencana Mingguan yang Efektif
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Buat target yang spesifik dan terukur</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Alokasikan waktu secara realistis</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Sertakan sumber belajar yang jelas</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Review dan sesuaikan secara berkala</span>
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
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Membuat...';
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
