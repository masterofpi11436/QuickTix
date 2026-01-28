<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Statuses') }}
            </h2>

            <x-custom-button href="{{ route('admin.administration') }}" color="green">
                Administration
            </x-custom-button>
        </div>
    </x-slot>

    <!-- Flash Message -->
    <x-flash-message type="success" />
    <x-flash-message type="error" />

    @livewire('Admin.Statuses.Search')
</x-admin-app-layout>
