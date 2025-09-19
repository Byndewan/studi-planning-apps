<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Peta Konsep</h1>
            <p class="text-gray-600 mt-1 text-base">{{ $conceptMap->title }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('concept-maps.show', $conceptMap) }}" class="btn-secondary">
                <i class="fas fa-eye mr-2"></i>
                Lihat Peta
            </a>
            <a href="{{ route('concept-maps.index') }}" class="btn-secondary">
                <i class="fas fa-list mr-2"></i>
                Semua Peta
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        <div class="card card-hover">
            <div class="p-8">
                <form method="POST" action="{{ route('concept-maps.update', $conceptMap) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Info Mata Kuliah (Read-only) -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-blue-900">Mata Kuliah</p>
                                <p class="text-lg font-semibold text-blue-800">{{ $conceptMap->course->name }}</p>
                                <p class="text-sm text-blue-600">{{ $conceptMap->course->semester->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Judul Peta Konsep -->
                    <div class="group">
                        <x-input-label for="title" :value="__('Judul Peta Konsep')" />
                        <div class="relative">
                            <i class="fas fa-heading absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <x-text-input id="title" type="text" name="title" :value="old('title', $conceptMap->title)"
                                required class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                        </div>
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('concept-maps.show', $conceptMap) }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn-primary btn-animate">
                            <span class="flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Perbarui Peta Konsep
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informasi Peta Konsep -->
        <div class="card card-hover">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informasi Peta Konsep
                </h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Dibuat</span>
                        <span class="font-medium text-gray-900">{{ $conceptMap->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Diperbarui</span>
                        <span class="font-medium text-gray-900">{{ $conceptMap->updated_at->format('d M Y H:i') }}</span>
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
                    Setelah Anda menghapus peta konsep ini, semua data akan hilang permanen. Tindakan ini tidak dapat dibatalkan.
                </p>
                <form action="{{ route('concept-maps.destroy', $conceptMap) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus peta konsep ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700 text-white border-red-600">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Peta Konsep
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
