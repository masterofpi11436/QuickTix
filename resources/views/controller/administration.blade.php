<x-controller-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Administration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

                <!-- Intro -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-lg font-medium">
                            Configure the QuickTix application.
                        </p>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Manage core system data used throughout the platform.
                        </p>
                    </div>
                </div>

                <!-- Admin Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Users -->
                    <a href="{{ route('controller.users.index') }}"
                        class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-indigo-600">
                                Users
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Manage Users
                            </p>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-controller-app-layout>
