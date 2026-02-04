<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ticket Templates') }}
            </h2>
        </div>
    </x-slot>

    @livewire('Admin.TicketTemplates.Form', ['id' => $template->id])
</x-admin-app-layout>
