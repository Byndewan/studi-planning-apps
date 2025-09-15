@props(['class' => 'w-8 h-8'])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" {{ $attributes->merge(['class' => $class]) }}>
    <defs>
        <linearGradient id="mark-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#6366f1" />
            <stop offset="100%" style="stop-color:#8b5cf6" />
        </linearGradient>
    </defs>
    <rect x="3" y="3" width="18" height="18" rx="4" stroke="url(#mark-gradient)" stroke-width="2"/>
    <path d="M9 9h6v6H9z" stroke="url(#mark-gradient)" stroke-width="1.5"/>
    <circle cx="12" cy="12" r="2" fill="url(#mark-gradient)"/>
</svg>
