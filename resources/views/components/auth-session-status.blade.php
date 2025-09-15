@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700']) }}>
        {{ is_array($status) ? implode(', ', $status) : $status }}
    </div>
@endif
