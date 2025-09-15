@props(['href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors']) }}>
    {{ $slot }}
</a>
