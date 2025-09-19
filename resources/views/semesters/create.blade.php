<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Tambah Semester Baru</h1>
                <p class="text-gray-600 mt-1 text-base">Buat semester akademik baru</p>
            </div>
            <x-slot name="headerActions">
                <a href="{{ route('semesters.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </x-slot>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="card card-hover">
            <div class="p-8">
                <form method="POST" action="{{ route('semesters.store') }}" class="space-y-8">
                    @csrf

                    <!-- Semester Name -->
                    <div class="group">
                        <x-input-label for="name" :value="__('Nama Semester')" />
                        <div class="relative">
                            <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <x-text-input id="name" type="text" name="name" :value="old('name')" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="Contoh: Semester Ganjil 2024/2025" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                            <x-date-picker id="start_date" name="start_date" :value="old('start_date')" required />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                            <x-date-picker id="end_date" name="end_date" :value="old('end_date')" required />
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="group">
                        <x-input-label for="notes" :value="__('Catatan (Opsional)')" />
                        <textarea id="notes" name="notes" rows="4"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Informasi tambahan tentang semester ini...">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('semesters.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn-primary btn-animate">
                            <span class="flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Semester
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Information -->
        <div class="mt-8 card card-hover">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-lightbulb mr-2 text-yellow-600"></i>
                    Tips Membuat Semester
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-blue-600 text-xs"></i>
                            </div>
                            <span>Gunakan nama yang jelas seperti "Semester Ganjil 2024/2025"</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-blue-600 text-xs"></i>
                            </div>
                            <span>Pastikan tanggal mencakup periode perkuliahan dan UAS</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-blue-600 text-xs"></i>
                            </div>
                            <span>Semester aktif ditentukan berdasarkan tanggal saat ini</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-blue-600 text-xs"></i>
                            </div>
                            <span>Anda bisa menambah mata kuliah setelah membuat semester</span>
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
