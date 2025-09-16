@props(['class' => 'w-6 h-6'])

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
    stroke-width="1.5" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
    <path stroke-linecap="round" stroke-linejoin="round"
        d="M4.5 4.5h15v12h-15zM8.25 18h7.5v1.5h-7.5z" />
</svg>
