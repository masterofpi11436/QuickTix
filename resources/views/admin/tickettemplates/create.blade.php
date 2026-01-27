<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-800">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create a Ticket Tmeplate]') }}
            </h2>
        </div>
    </x-slot>

    @livewire('Admin.TicketTemplates.Form')
</x-admin-app-layout>
