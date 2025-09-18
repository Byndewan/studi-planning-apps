@props(['type' => 'success', 'message' => ''])

<div x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform translate-y-2"
     x-init="setTimeout(() => show = false, 5000)"
     @class([
        'fixed top-4 right-4 z-50 p-4 rounded-2xl shadow-lg border max-w-sm animate-slideIn',
        'bg-white border-green-200' => $type === 'success',
        'bg-white border-red-200' => $type === 'error',
        'bg-white border-blue-200' => $type === 'info',
        'bg-white border-yellow-200' => $type === 'warning',
     ])>
    <div class="flex items-start">
        <div class="flex-shrink-0">
            @if($type === 'success')
                <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600 text-xs"></i>
                </div>
            @elseif($type === 'error')
                <div class="w-5 h-5 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-times text-red-600 text-xs"></i>
                </div>
            @endif
        </div>
        <div class="ml-3 flex-1">
            <p class="text-sm font-medium text-gray-900">
                {{ $message }}
            </p>
        </div>
        <button @click="show = false" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>
</div>
