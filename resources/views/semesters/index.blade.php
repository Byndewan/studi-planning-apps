<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Semester</h1>
                <p class="text-gray-600 mt-1">Kelola semester akademik Anda</p>
            </div>
            <x-slot name="headerActions">
                <a href="{{ route('semesters.create') }}" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Semester
                </a>
            </x-slot>
        </div>
    </x-slot>

    <div class="space-y-8">
        @if($semesters->isEmpty())
            <div class="card card-hover">
                <div class="empty-state py-16">
                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <i class="fas fa-calendar-alt text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada semester</h3>
                    <p class="text-gray-600 mb-6">Mulai dengan menambahkan semester pertama Anda</p>
                    <a href="{{ route('semesters.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Semester
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($semesters as $semester)
                    <div class="card card-hover group">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $semester->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ \Carbon\Carbon::parse($semester->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($semester->end_date)->format('d M Y') }}
                                    </p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $semester->is_current ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $semester->is_current ? 'Aktif' : 'Selesai' }}
                                </span>
                            </div>

                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Mata Kuliah</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $semester->courses_count }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Durasi</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $semester->start_date->diffInWeeks($semester->end_date) }} minggu</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Status</span>
                                    <span class="text-sm font-semibold {{ $semester->is_current ? 'text-green-600' : 'text-gray-600' }}">
                                        {{ $semester->is_current ? 'Berjalan' : 'Selesai' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <a href="{{ route('semesters.show', $semester) }}"
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-blue-800 hover:bg-blue-50 bg-gray-50 rounded-lg transition-all duration-200">
                                    <i class="fas fa-eye mr-2"></i>
                                    Detail
                                </a>
                                <a href="{{ route('semesters.edit', $semester) }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-all duration-200">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($semesters->hasPages())
                <div class="mt-6">
                    {{ $semesters->links() }}
                </div>
            @endif
        @endif
    </div>

    <style>
        /* Card animation */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Status badge animation */
        .group:hover .text-lg {
            transform: translateX(4px);
            transition: transform 0.2s ease;
        }

        /* Button animation */
        .group:hover .fa-eye,
        .group:hover .fa-edit {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }
    </style>

    <script>
        // Add smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s both`;
            });
        });
    </script>
</x-app-layout>
