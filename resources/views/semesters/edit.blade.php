<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Semester</h1>
            <p class="text-gray-600 mt-1 text-base">{{ $semester->name }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('semesters.show', $semester) }}" class="btn-secondary">
                <i class="fas fa-eye mr-2"></i>
                Lihat Semester
            </a>
            <a href="{{ route('semesters.index') }}" class="btn-secondary">
                <i class="fas fa-list mr-2"></i>
                Semua Semester
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-8">
        <div class="card card-hover">
            <div class="p-8">
                <form method="POST" action="{{ route('semesters.update', $semester) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Nama Semester -->
                    <div class="group">
                        <x-input-label for="name" :value="__('Nama Semester')" />
                        <div class="relative">
                            <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <x-text-input id="name" type="text" name="name" :value="old('name', $semester->name)" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="Contoh: Gasal 2024, Genap 2024/2025" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal Mulai -->
                        <div class="group">
                            <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                            <div class="relative">
                                <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="start_date" type="date" name="start_date" :value="old('start_date', $semester->start_date->format('Y-m-d'))" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                            </div>
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="group">
                            <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                            <div class="relative">
                                <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="end_date" type="date" name="end_date" :value="old('end_date', $semester->end_date->format('Y-m-d'))" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                            </div>
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <x-input-label value="Status Saat Ini" />
                        <div class="mt-2">
                            <span class="px-3 py-1 text-sm font-medium rounded-full {{ $semester->is_current ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $semester->is_current ? 'Semester Aktif' : 'Semester Lalu' }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Status ditentukan otomatis berdasarkan tanggal saat ini.</p>
                    </div>

                    <!-- Jumlah Mata Kuliah -->
                    <div>
                        <x-input-label value="Jumlah Mata Kuliah" />
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $semester->courses_count }} mata kuliah</p>
                        @if($semester->courses_count > 0)
                            <p class="text-xs text-gray-500 mt-1">
                                Mengubah tanggal dapat memengaruhi semua mata kuliah di semester ini.
                            </p>
                        @endif
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('semesters.show', $semester) }}" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn-primary btn-animate">
                            <span class="flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Perbarui Semester
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informasi Semester -->
        <div class="card card-hover">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informasi Semester
                </h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Dibuat</span>
                        <span class="font-medium text-gray-900">{{ $semester->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Diperbarui</span>
                        <span class="font-medium text-gray-900">{{ $semester->updated_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zona Bahaya -->
        @if($semester->courses_count === 0)
            <div class="card card-hover border border-red-200">
                <div class="p-6 bg-red-50 border-b border-red-200">
                    <h3 class="text-lg font-semibold text-red-800 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Zona Bahaya
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-4">
                        Setelah Anda menghapus semester ini, tidak akan bisa dikembalikan. Harap berhati-hati.
                    </p>
                    <form action="{{ route('semesters.destroy', $semester) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus semester ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus Semester
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="card card-hover border border-yellow-200">
                <div class="p-6 bg-yellow-50 border-b border-yellow-200">
                    <h3 class="text-lg font-semibold text-yellow-800 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Hapus Dibatasi
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-yellow-700 mb-4">
                        Semester ini tidak dapat dihapus karena masih memiliki mata kuliah.
                        Harap hapus semua mata kuliah terlebih dahulu sebelum menghapus semester.
                    </p>
                    <a href="{{ route('semesters.show', $semester) }}" class="btn-secondary">
                        <i class="fas fa-book mr-2"></i>
                        Lihat Mata Kuliah
                    </a>
                </div>
            </div>
        @endif
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
