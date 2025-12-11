@props(['href' => '#', 'color' => 'blue', 'method' => null])

@php
$styles = [
    'blue' =>
        'bg-transparent dark:bg-transparent
         border-blue-600 text-blue-700 dark:text-blue-400 dark:border-blue-400
         hover:bg-blue-50 dark:hover:bg-blue-900',

    'green' =>
        'bg-transparent dark:bg-transparent
         border-green-600 text-green-700 dark:text-green-400 dark:border-green-400
         hover:bg-green-50 dark:hover:bg-green-900',

    'yellow' =>
        'bg-transparent dark:bg-transparent
         border-yellow-600 text-yellow-700 dark:text-yellow-400 dark:border-yellow-400
         hover:bg-yellow-50 dark:hover:bg-yellow-900',

    'red' =>
        'bg-transparent dark:bg-transparent
         border-red-600 text-red-700 dark:text-red-400 dark:border-red-400
         hover:bg-red-50 dark:hover:bg-red-900',
];

$classes = 'px-4 py-2 rounded-md text-sm border ' . ($styles[$color] ?? $styles['blue']);
@endphp

@if ($method)
    <form action="{{ $href }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
        @csrf
        @method($method)
        <button type="submit" class="{{ $classes }}">
            {{ $slot }}
        </button>
    </form>
@else
    <a href="{{ $href }}" class="{{ $classes }}">
        {{ $slot }}
    </a>
@endif
