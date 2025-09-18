<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Mata Kuliah</h1>
                <p class="text-gray-600 mt-1">{{ $course->code }} - {{ $course->name }}</p>
            </div>
            <x-slot name="headerActions">
                <a href="{{ route('courses.show', $course) }}" class="btn-secondary">
                    <i class="fas fa-eye mr-2"></i>
                    Detail
                </a>
                <a href="{{ route('courses.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </x-slot>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Edit Form -->
        <div class="card card-hover">
            <div class="p-8">
                <form method="POST" action="{{ route('courses.update', $course) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Semester Info (Read-only) -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-blue-900">Semester</p>
                                <p class="text-lg font-semibold text-blue-800">{{ $course->semester->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Course Code & Name Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-input-label for="code" :value="__('Kode Mata Kuliah')" />
                            <div class="relative">
                                <i class="fas fa-hashtag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="code" type="text" name="code" :value="old('code', $course->code)" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="IF101" />
                            </div>
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="name" :value="__('Nama Mata Kuliah')" />
                            <div class="relative">
                                <i class="fas fa-book absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="name" type="text" name="name" :value="old('name', $course->name)" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="Pemrograman Web" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <!-- SKS & Total Modules Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-input-label for="sks" :value="__('SKS (Kredit)')" />
                            <div class="relative">
                                <i class="fas fa-coins absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="sks" type="number" name="sks" :value="old('sks', $course->sks)" required
                                    min="1" max="6"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="3" />
                            </div>
                            <x-input-error :messages="$errors->get('sks')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="total_modules" :value="__('Total Modul')" />
                            <div class="relative">
                                <i class="fas fa-layer-group absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="total_modules" type="number" name="total_modules" :value="old('total_modules', $course->total_modules)"
                                    min="0"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="14" />
                            </div>
                            <x-input-error :messages="$errors->get('total_modules')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="group">
                        <x-input-label for="notes" :value="__('Catatan (Opsional)')" />
                        <textarea id="notes" name="notes" rows="4"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Informasi tambahan tentang mata kuliah ini...">{{ old('notes', $course->notes) }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('courses.show', $course) }}"
                            class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn-primary btn-animate">
                            <span class="flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Perbarui Mata Kuliah
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Course Information -->
        <div class="card card-hover">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informasi Mata Kuliah
                </h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Dibuat</span>
                        <span class="font-medium text-gray-900">{{ $course->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Diperbarui</span>
                        <span class="font-medium text-gray-900">{{ $course->updated_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="card card-hover border border-red-200">
            <div class="p-6 bg-red-50 border-b border-red-200">
                <h3 class="text-lg font-semibold text-red-800 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Zona Bahaya
                </h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">
                    Setelah Anda menghapus mata kuliah ini, semua data terkait (rencana mingguan, entri monitoring, sesi SQ3R, dan peta konsep) juga akan dihapus. Tindakan ini tidak dapat dibatalkan.
                </p>
                <form action="{{ route('courses.destroy', $course) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini? Semua data terkait akan ikut terhapus.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700 text-white border-red-600">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Mata Kuliah
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
