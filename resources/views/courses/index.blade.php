<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Mata Kuliah</h1>
                <p class="text-gray-600 text-base mt-1">Kelola mata kuliah akademik Anda</p>
            </div>
            <x-slot name="headerActions">
                <a href="{{ route('courses.create') }}" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Mata Kuliah
                </a>
            </x-slot>
        </div>
    </x-slot>

    <div class="space-y-8">
        @if($courses->isEmpty())
            <div class="card card-hover">
                <div class="empty-state py-16">
                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <i class="fas fa-book text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada mata kuliah</h3>
                    <p class="text-gray-600 mb-6">Mulai dengan menambahkan mata kuliah pertama Anda</p>
                    <a href="{{ route('courses.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Mata Kuliah
                    </a>
                </div>
            </div>
        @else
            <div class="card card-hover overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Semester
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Mata Kuliah
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    SKS
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Modul
                                </th>
                                <th scope="col" class="relative px-6 py-4">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($courses as $course)
                                <tr class="hover:bg-gray-50 transition-all duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $course->semester->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $course->code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $course->name }}</div>
                                        @if($course->notes)
                                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($course->notes, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $course->sks }} SKS
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $course->total_modules }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('courses.show', $course) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                                <i class="fas fa-eye mr-1"></i>
                                                Lihat
                                            </a>
                                            <a href="{{ route('courses.edit', $course) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-all duration-200">
                                                <i class="fas fa-edit mr-1"></i>
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if ($courses->hasPages())
                <div class="mt-6">
                    {{ $courses->links() }}
                </div>
            @endif
        @endif
    </div>

    <style>
        /* Table row animation */
        tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        tr:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Status badge animation */
        .status-badge {
            transition: all 0.2s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        /* Action buttons animation */
        .text-blue-600, .text-gray-600 {
            transition: all 0.2s ease;
        }

        .text-blue-600:hover, .text-gray-600:hover {
            transform: translateY(-1px);
        }
    </style>
</x-app-layout>
