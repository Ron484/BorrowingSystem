@props(['active', 'iconClass','navigate'])

@php
$classes = ($active ?? false)
            ? 'flex space-x-2 items-center  hover:text-green-500 text-sm text-gray-500'
            : 'flex space-x-2 items-center  hover:text-green-500 text-sm text-gray-500';

            
@endphp


<div class="{{ $classes }}" >
    @isset($iconClass)
        <i class="{{ $iconClass }}" style="color: rgb(176, 211, 49);"></i>
    @endisset
</div>

<a {{$navigate ?? true? 'wire:navigate' : ''}} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
