<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Monitoring Belajar</h1>
                <p class="text-gray-600 mt-1 text-base">{{ $monitoring->date->format('d M Y') }} - {{ $monitoring->course->name }}
                </p>
            </div>
            <x-slot name="headerActions">
                <a href="{{ route('monitorings.edit', $monitoring) }}" class="btn-secondary">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Entri
                </a>
                <a href="{{ route('courses.show', $monitoring->course) }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Mata Kuliah
                </a>
            </x-slot>
        </div>
    </x-slot>

    <div class="max-w-full mx-auto space-y-8">
        <!-- Info Utama -->
        <div class="card">
            <div class="p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $monitoring->course->name }}</h2>
                        <p class="text-gray-600 mt-1 text-base">
                            Minggu {{ $monitoring->week_number }} • {{ $monitoring->date->format('d M Y') }}
                        </p>
                    </div>
                    <span class="status-badge {{ $monitoring->achieved ? 'status-completed' : 'status-missed' }}">
                        {{ $monitoring->achieved ? 'Tercapai' : 'Tidak Tercapai' }}
                    </span>
                </div>

                <!-- Detail Studi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                        <h3 class="text-sm font-semibold text-blue-900 mb-3 flex items-center">
                            <i class="fas fa-bullseye mr-2"></i>
                            Kegiatan yang Direncanakan
                        </h3>
                        <p class="text-blue-900">{{ $monitoring->planned }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                        <h3 class="text-sm font-semibold text-green-900 mb-3 flex items-center">
                            <i class="fas fa-check-double mr-2"></i>
                            Kegiatan yang Dilakukan
                        </h3>
                        <p class="text-green-900">{{ $monitoring->actual }}</p>
                    </div>
                </div>

                <!-- Analisis -->
                @if ($monitoring->cause || $monitoring->solution)
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-analytics mr-2 text-purple-600"></i>
                            Analisis
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if ($monitoring->cause)
                                <div
                                    class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 border border-yellow-200">
                                    <h4 class="text-sm font-semibold text-yellow-900 mb-2 flex items-center">
                                        <i class="fas fa-search mr-2"></i>
                                        Penyebab Perbedaan
                                    </h4>
                                    <p class="text-yellow-900">{{ $monitoring->cause }}</p>
                                </div>
                            @endif
                            @if ($monitoring->solution)
                                <div
                                    class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                                    <h4 class="text-sm font-semibold text-purple-900 mb-2 flex items-center">
                                        <i class="fas fa-lightbulb mr-2"></i>
                                        Solusi yang Diusulkan
                                    </h4>
                                    <p class="text-purple-900">{{ $monitoring->solution }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Konteks Mata Kuliah -->
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                        Konteks Mata Kuliah
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <span class="text-gray-600 text-xs">Semester</span>
                            <p class="font-medium text-gray-900">{{ $monitoring->course->semester->name }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <span class="text-gray-600 text-xs">Kode</span>
                            <p class="font-medium text-gray-900">{{ $monitoring->course->code }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <span class="text-gray-600 text-xs">SKS</span>
                            <p class="font-medium text-gray-900">{{ $monitoring->course->sks }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <span class="text-gray-600 text-xs">Total Modul</span>
                            <p class="font-medium text-gray-900">{{ $monitoring->course->total_modules }}</p>
                        </div>
                    </div>
                </div>

                <!-- Aksi -->
                <div class="border-t border-gray-200 pt-6 mt-6 flex justify-end space-x-3">
                    <a href="{{ route('monitorings.edit', $monitoring) }}" class="btn-primary">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Entri
                    </a>
                    <form action="{{ route('monitorings.destroy', $monitoring) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus entri monitoring ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary bg-red-600 hover:bg-red-700 text-white">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Informasi Tambahan -->
        <div class="card">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informasi Entri
                </h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Dibuat</span>
                        <span
                            class="font-medium text-gray-900">{{ $monitoring->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Diperbarui</span>
                        <span
                            class="font-medium text-gray-900">{{ $monitoring->updated_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Button animation */
        .btn-animate {
            position: relative;
            overflow: hidden;
        }

        .btn-animate::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .btn-animate:hover::before {
            left: 100%;
        }
    </style>
</x-app-layout>
