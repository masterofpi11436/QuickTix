<x-controller-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Areas') }}
            </h2>

            <x-custom-button href="{{ route('controller.administration') }}" color="green">
                Administration
            </x-custom-button>
        </div>
    </x-slot>

    @livewire('Admin.Areas.Form', ['id' => $area->id])
</x-controller-app-layout>
