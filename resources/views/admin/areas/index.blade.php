<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Areas') }}
        </h2>
    </x-slot>

    @livewire('admin.areas.search')
</x-admin-app-layout>
