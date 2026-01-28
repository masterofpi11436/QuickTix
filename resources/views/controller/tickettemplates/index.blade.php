<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticket Templates') }}
        </h2>
    </x-slot>

    @livewire('Admin.TicketTemplates.Search')
</x-admin-app-layout>
