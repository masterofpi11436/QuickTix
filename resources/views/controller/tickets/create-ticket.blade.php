<x-controller-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-800">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create a Ticket') }}
            </h2>

            <x-custom-button href="{{ route('controller.tickets.index') }}" color="green">
                Back
            </x-custom-button>
        </div>
    </x-slot>

    @livewire('Tickets.CreateForm')
</x-controller-app-layout>
