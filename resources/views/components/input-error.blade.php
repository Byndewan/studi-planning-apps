@props(['messages' => []])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'mt-2 text-sm text-red-600']) }}>
        @foreach ((array) $messages as $message)
            @if(is_array($message))
                @foreach($message as $m)
                    <li>{{ $m }}</li>
                @endforeach
            @else
                <li>{{ $message }}</li>
            @endif
        @endforeach
    </ul>
@endif
