<x-controller-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Users') }}
            </h2>
        </div>
    </x-slot>

    {{-- Flash Messages --}}
    <x-flash-message type="success" />

    @livewire('Controller.Users.Search')
</x-controller-app-layout>
