@props([
    'type' => 'success',
])

@php
    $colors = [
        'success' => 'bg-green-500',
        'error'   => 'bg-red-500',
        'warning' => 'bg-yellow-500',
        'info'    => 'bg-blue-500',
    ];
@endphp

@if (session()->has($type))
    <div
        id="flash-message"
        class="fixed bottom-5 right-5 {{ $colors[$type] ?? 'bg-gray-500' }} text-white px-4 py-3 rounded-md shadow-lg flex items-center space-x-4 animate-fade-in"
    >
        <span>{{ session($type) }}</span>

        <button
            class="text-white font-bold focus:outline-none"
            onclick="this.parentElement.style.display='none';"
        >
            &times;
        </button>
    </div>
@endif
