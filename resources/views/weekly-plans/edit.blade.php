<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Rencana Mingguan</h1>
            <p class="text-gray-600 mt-1 text-base">{{ $weeklyPlan->course->name }} - Minggu {{ $weeklyPlan->week_number }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('weekly-plans.show', $weeklyPlan) }}" class="btn-secondary">
                <i class="fas fa-eye mr-2"></i>
                Lihat Rencana
            </a>
            <a href="{{ route('weekly-plans.index') }}" class="btn-secondary">
                <i class="fas fa-list mr-2"></i>
                Semua Rencana
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-8">
        <div class="card card-hover">
            <div class="p-8">
                <form method="POST" action="{{ route('weekly-plans.update', $weeklyPlan) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Info Mata Kuliah (Read-only) -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-blue-900">Mata Kuliah</p>
                                    <p class="text-lg font-semibold text-blue-800">{{ $weeklyPlan->course->name }}</p>
                                    <p class="text-sm text-blue-600">{{ $weeklyPlan->course->semester->name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Nomor Minggu -->
                        <div class="group">
                            <x-input-label for="week_number" :value="__('Nomor Minggu')" />
                            <div class="relative">
                                <i class="fas fa-calendar-week absolute right-5 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <select id="week_number" name="week_number" required class="form-input mt-1 block w-full">
                                    @for($i = 1; $i <= 14; $i++)
                                        <option value="{{ $i }}" {{ old('week_number', $weeklyPlan->week_number) == $i ? 'selected' : '' }}>
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
                            placeholder="Apa yang ingin Anda pelajari minggu ini?">{{ old('target_text', $weeklyPlan->target_text) }}</textarea>
                        <x-input-error :messages="$errors->get('target_text')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Jam yang Direncanakan -->
                        <div class="group">
                            <x-input-label for="planned_hours" :value="__('Jam yang Direncanakan')" />
                            <div class="relative">
                                <i class="fas fa-clock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="planned_hours" type="number" name="planned_hours"
                                    :value="old('planned_hours', $weeklyPlan->planned_hours)"
                                    min="0" step="0.5" required class="mt-1 block w-full pl-10" />
                            </div>
                            <x-input-error :messages="$errors->get('planned_hours')" class="mt-2" />
                        </div>

                        <!-- Jumlah Halaman -->
                        <div class="group">
                            <x-input-label for="num_pages" :value="__('Jumlah Halaman')" />
                            <div class="relative">
                                <i class="fas fa-file-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="num_pages" type="number" name="num_pages"
                                    :value="old('num_pages', $weeklyPlan->num_pages)"
                                    min="0" required class="mt-1 block w-full pl-10" />
                            </div>
                            <x-input-error :messages="$errors->get('num_pages')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="group">
                            <x-input-label for="status" :value="__('Status')" />
                            <div class="relative">
                                <i class="fas fa-flag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <select id="status" name="status" required class="form-input mt-1 block w-full pl-10">
                                    <option value="planned" {{ old('status', $weeklyPlan->status) == 'planned' ? 'selected' : '' }}>Direncanakan</option>
                                    <option value="in_progress" {{ old('status', $weeklyPlan->status) == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                                    <option value="completed" {{ old('status', $weeklyPlan->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="missed" {{ old('status', $weeklyPlan->status) == 'missed' ? 'selected' : '' }}>Terlewat</option>
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
                        <a href="{{ route('weekly-plans.show', $weeklyPlan) }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn-primary btn-animate">
                            <span class="flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Perbarui Rencana
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informasi Rencana -->
        <div class="card card-hover">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informasi Rencana
                </h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Dibuat</span>
                        <span class="font-medium text-gray-900">{{ $weeklyPlan->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Diperbarui</span>
                        <span class="font-medium text-gray-900">{{ $weeklyPlan->updated_at->format('d M Y H:i') }}</span>
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
                    Setelah Anda menghapus rencana mingguan ini, tidak akan bisa dikembalikan. Harap berhati-hati.
                </p>
                <form action="{{ route('weekly-plans.destroy', $weeklyPlan) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus rencana mingguan ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Rencana
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
