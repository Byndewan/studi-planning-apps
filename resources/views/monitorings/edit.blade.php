<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Entri Monitoring</h1>
            <p class="text-gray-600 mt-1">{{ $monitoring->date->format('d M Y') }} - {{ $monitoring->course->name }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('monitorings.show', $monitoring) }}" class="btn-secondary">
                <i class="fas fa-eye mr-2"></i>
                Lihat Entri
            </a>
            <a href="{{ route('monitorings.index') }}" class="btn-secondary">
                <i class="fas fa-list mr-2"></i>
                Semua Entri
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        <div class="card card-hover">
            <div class="p-8">
                <form method="POST" action="{{ route('monitorings.update', $monitoring) }}" class="space-y-8">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="course_id" value="{{ $monitoring->course_id }}">

                    <!-- Info Mata Kuliah (Read-only) -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-blue-900">Mata Kuliah</p>
                                <p class="text-lg font-semibold text-blue-800">{{ $monitoring->course->name }}</p>
                                <p class="text-sm text-blue-600">{{ $monitoring->course->semester->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal -->
                        <div class="group">
                            <x-input-label for="date" :value="__('Tanggal')" />
                            <div class="relative">
                                <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="date" type="date" name="date" :value="old('date', $monitoring->date->format('Y-m-d'))" required
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
                                    @for($i = 1; $i <= 14; $i++)
                                        <option value="{{ $i }}" {{ old('week_number', $monitoring->week_number) == $i ? 'selected' : '' }}>
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
                            placeholder="Apa yang Anda rencanakan untuk dipelajari?">{{ old('planned', $monitoring->planned) }}</textarea>
                        <x-input-error :messages="$errors->get('planned')" class="mt-2" />
                    </div>

                    <!-- Kegiatan yang Dilakukan -->
                    <div class="group">
                        <x-input-label for="actual" :value="__('Kegiatan yang Dilakukan')" />
                        <textarea id="actual" name="actual" rows="4" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Apa yang benar-benar Anda capai?">{{ old('actual', $monitoring->actual) }}</textarea>
                        <x-input-error :messages="$errors->get('actual')" class="mt-2" />
                    </div>

                    <!-- Penyebab Perbedaan -->
                    <div class="group">
                        <x-input-label for="cause" :value="__('Penyebab Perbedaan')" />
                        <textarea id="cause" name="cause" rows="3"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Mengapa ada perbedaan antara yang direncanakan dan yang dilakukan?">{{ old('cause', $monitoring->cause) }}</textarea>
                        <x-input-error :messages="$errors->get('cause')" class="mt-2" />
                    </div>

                    <!-- Solusi -->
                    <div class="group">
                        <x-input-label for="solution" :value="__('Solusi/Perbaikan')" />
                        <textarea id="solution" name="solution" rows="3"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Bagaimana Anda bisa memperbaikinya untuk lain kali?">{{ old('solution', $monitoring->solution) }}</textarea>
                        <x-input-error :messages="$errors->get('solution')" class="mt-2" />
                    </div>

                    <!-- Tercapai -->
                    <div class="flex items-center">
                        <input type="checkbox" id="achieved" name="achieved" value="1" {{ old('achieved', $monitoring->achieved) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-4 w-4">
                        <x-input-label for="achieved" :value="__('Tandai sebagai tercapai')" class="ml-3 mb-0 text-gray-700" />
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('monitorings.show', $monitoring) }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn-primary btn-animate">
                            <span class="flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Perbarui Entri
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informasi Entri -->
        <div class="card card-hover">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informasi Entri
                </h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Dibuat</span>
                        <span class="font-medium text-gray-900">{{ $monitoring->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Diperbarui</span>
                        <span class="font-medium text-gray-900">{{ $monitoring->updated_at->format('d M Y H:i') }}</span>
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
                    Setelah Anda menghapus entri monitoring ini, tidak akan bisa dikembalikan. Harap berhati-hati.
                </p>
                <form action="{{ route('monitorings.destroy', $monitoring) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus entri monitoring ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Entri
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
