@props(['messages' => []])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'mt-2 text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            @if(is_array($message))
                @foreach($message as $m)
                    <li class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ $m }}
                    </li>
                @endforeach
            @else
                <li class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ $message }}
                </li>
            @endif
        @endforeach
    </ul>
@endif
