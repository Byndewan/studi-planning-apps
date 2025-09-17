@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-4 py-4 text-sm font-medium rounded-xl bg-indigo-50 text-indigo-700'
            : 'flex items-center gap-3 px-2 py-2 text-sm font-medium rounded-xl text-gray-600 bg-gray-50 hover:bg-gray-100 hover:text-gray-900 transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
