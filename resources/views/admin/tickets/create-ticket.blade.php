<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create a Ticket') }}
            </h2>

            <x-custom-button href="{{ route('admin.tickets.index') }}" color="green">
                Back
            </x-custom-button>
        </div>
    </x-slot>

    @livewire('admin.tickets.form')
</x-admin-app-layout>
