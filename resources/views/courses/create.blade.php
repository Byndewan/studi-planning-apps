<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Tambah Mata Kuliah Baru</h1>
                <p class="text-gray-600 mt-1 text-base">Tambahkan mata kuliah ke semester Anda</p>
            </div>
            <x-slot name="headerActions">
                <a href="{{ route('courses.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </x-slot>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="card card-hover">
            <div class="p-8">
                <form method="POST" action="{{ route('courses.store') }}" class="space-y-8">
                    @csrf

                    <!-- Semester Selection -->
                    <div class="group">
                        <x-input-label for="semester_id" :value="__('Semester')" />
                        <div class="relative">
                            <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <select id="semester_id" name="semester_id" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">Pilih Semester</option>
                                @foreach(auth()->user()->semesters as $semester)
                                    <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->name }} ({{ $semester->period }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('semester_id')" class="mt-2" />
                    </div>

                    <!-- Course Code & Name Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-input-label for="code" :value="__('Kode Mata Kuliah')" />
                            <div class="relative">
                                <i class="fas fa-hashtag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="code" type="text" name="code" :value="old('code')" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="IF101" />
                            </div>
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="name" :value="__('Nama Mata Kuliah')" />
                            <div class="relative">
                                <i class="fas fa-book absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <x-text-input id="name" type="text" name="name" :value="old('name')" required
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
                                <x-text-input id="sks" type="number" name="sks" :value="old('sks')" required
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
                                <x-text-input id="total_modules" type="number" name="total_modules" :value="old('total_modules')"
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
                            placeholder="Informasi tambahan tentang mata kuliah ini...">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('courses.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>

                        <button type="submit"
                            class="btn-primary btn-animate">
                            <span class="flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Mata Kuliah
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
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Tips Menambah Mata Kuliah
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Pilih semester yang sesuai untuk organisasi yang lebih baik</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Gunakan kode mata kuliah yang konsisten (misalnya: IF101)</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>SKS menentukan beban studi per minggu</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span>Total modul membantu dalam perencanaan mingguan</span>
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
