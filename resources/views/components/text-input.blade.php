@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge([
    'class' => 'form-input border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm'
]) }}>
