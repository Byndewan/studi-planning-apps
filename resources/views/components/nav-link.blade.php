@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg bg-indigo-50 text-indigo-700'
            : 'flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
