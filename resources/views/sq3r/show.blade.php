<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Sesi SQ3R</h1>
            <p class="text-gray-600 mt-1">{{ $sq3rSession->module_title }}</p>
        </div>
        <x-slot name="headerActions">
            <a href="{{ route('sq3r.edit', $sq3rSession) }}" class="btn-secondary">
                <i class="fas fa-edit mr-2"></i>
                Edit Sesi
            </a>
            <a href="{{ route('courses.show', $sq3rSession->course) }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Mata Kuliah
            </a>
        </x-slot>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Info Utama -->
        <div class="card card-hover">
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="group">
                        <p class="text-sm font-medium text-gray-600">Mata Kuliah</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1 group-hover:text-blue-600 transition-colors">{{ $sq3rSession->course->name }}</p>
                    </div>
                    <div class="group">
                        <p class="text-sm font-medium text-gray-600">Modul</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1 group-hover:text-green-600 transition-colors">{{ $sq3rSession->module_title }}</p>
                    </div>
                    <div class="group">
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1 group-hover:text-purple-600 transition-colors">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $sq3rSession->review_notes ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $sq3rSession->review_notes ? 'Selesai' : 'Dalam Proses' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Langkah-langkah SQ3R -->
        <div class="card card-hover">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-list-ol mr-2 text-blue-600"></i>
                    Langkah-langkah SQ3R
                </h2>

                <!-- Survey -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center mr-3">
                            <span class="font-bold">1</span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Survey</h3>
                        @if($sq3rSession->survey_notes)
                            <i class="fas fa-check-circle text-green-500 ml-2"></i>
                        @endif
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                        @if ($sq3rSession->survey_notes)
                            <p class="text-blue-900">{{ $sq3rSession->survey_notes }}</p>
                        @else
                            <p class="text-blue-700 italic">Belum ada catatan survey. Tinjau judul, subjudul, gambar, dan ringkasan untuk mendapatkan gambaran umum.</p>
                        @endif
                    </div>
                </div>

                <!-- Question -->
                @php
                    $questions = is_array($sq3rSession->questions)
                        ? $sq3rSession->questions
                        : json_decode($sq3rSession->questions, true) ?? [];
                @endphp
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-600 text-white rounded-xl flex items-center justify-center mr-3">
                            <span class="font-bold">2</span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Question (Pertanyaan)</h3>
                        @if(count($questions) > 0)
                            <i class="fas fa-check-circle text-green-500 ml-2"></i>
                        @endif
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
                        @if (count($questions) > 0)
                            <ul class="space-y-3">
                                @foreach ($questions as $index => $question)
                                    <li class="flex items-start">
                                        <span class="bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-sm font-bold mr-3 mt-0.5">
                                            {{ $index + 1 }}
                                        </span>
                                        <span class="text-green-900">{{ $question }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-green-700 italic">Belum ada pertanyaan yang dibuat. Ubah judul dan subjudul menjadi pertanyaan untuk memandu pembacaan.</p>
                        @endif
                    </div>
                </div>

                <!-- Read -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-yellow-600 text-white rounded-xl flex items-center justify-center mr-3">
                            <span class="font-bold">3</span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Read (Baca)</h3>
                        @if($sq3rSession->read_notes)
                            <i class="fas fa-check-circle text-green-500 ml-2"></i>
                        @endif
                    </div>
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-xl border border-yellow-200">
                        @if ($sq3rSession->read_notes)
                            <p class="text-yellow-900">{{ $sq3rSession->read_notes }}</p>
                        @else
                            <p class="text-yellow-700 italic">Belum ada catatan baca. Baca secara aktif sambil mencari jawaban untuk pertanyaan Anda.</p>
                        @endif
                    </div>
                </div>

                <!-- Recite -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-purple-600 text-white rounded-xl flex items-center justify-center mr-3">
                            <span class="font-bold">4</span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Recite (Ulang)</h3>
                        @if($sq3rSession->recite_notes)
                            <i class="fas fa-check-circle text-green-500 ml-2"></i>
                        @endif
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200">
                        @if ($sq3rSession->recite_notes)
                            <p class="text-purple-900">{{ $sq3rSession->recite_notes }}</p>
                        @else
                            <p class="text-purple-700 italic">Belum ada catatan ulang. Ringkas apa yang Anda pelajari dengan kata-kata Anda sendiri.</p>
                        @endif
                    </div>
                </div>

                <!-- Review -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-red-600 text-white rounded-xl flex items-center justify-center mr-3">
                            <span class="font-bold">5</span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Review (Ulangi)</h3>
                        @if($sq3rSession->review_notes)
                            <i class="fas fa-check-circle text-green-500 ml-2"></i>
                        @endif
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl border border-red-200">
                        @if ($sq3rSession->review_notes)
                            <p class="text-red-900">{{ $sq3rSession->review_notes }}</p>
                        @else
                            <p class="text-red-700 italic">Belum ada catatan ulangi. Kembali ke materi untuk memperkuat pemahaman Anda.</p>
                        @endif
                    </div>
                </div>

                <!-- Aksi -->
                <div class="border-t border-gray-200 pt-6 flex justify-end space-x-3">
                    <a href="{{ route('sq3r.edit', $sq3rSession) }}" class="btn-primary">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Sesi
                    </a>
                    <form action="{{ route('sq3r.destroy', $sq3rSession) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi SQ3R ini?')">
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
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Card hover animation */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Gradient background animation */
        .bg-gradient-to-br {
            transition: all 0.3s ease;
        }

        .bg-gradient-to-br:hover {
            transform: scale(1.02);
        }

        /* Icon animation */
        .group:hover .fa-list-ol,
        .group:hover .fa-check-circle {
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Number circle enhancement */
        .w-10.h-10 {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Status badge enhancement */
        .px-2.py-1 {
            font-weight: 500;
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
