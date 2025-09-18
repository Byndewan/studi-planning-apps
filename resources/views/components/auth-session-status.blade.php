@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'mb-6 p-4 bg-green-50 border border-green-200 rounded-xl animate-fadeInUp']) }}>
        <div class="flex items-center">
            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mr-3">
                <i class="fas fa-check text-green-600 text-xs"></i>
            </div>
            <p class="text-sm font-medium text-green-800">
                {{ is_array($status) ? implode(', ', $status) : $status }}
            </p>
        </div>
    </div>
@endif

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out;
    }
</style>
