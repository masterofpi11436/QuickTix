<x-reporting-user-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Reports') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 grid max-w-7xl mx-auto grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Departments Report -->
        <div class="bg-gray-800 rounded-lg shadow p-5">
            <h3 class="text-lg font-semibold text-white mb-2">Departments</h3>
        </div>

        <!-- New Reports -->
        <div class="bg-gray-800 rounded-lg shadow p-5">
            <h3 class="text-lg font-semibold text-white mb-2">New Reports</h3>
            <p class="text-gray-400 text-sm">
                Group by Department
            </p>
        </div>

        <!-- In Progress Reports -->
        <div class="bg-gray-800 rounded-lg shadow p-5">
            <h3 class="text-lg font-semibold text-white mb-2">In Progress</h3>
            <p class="text-gray-400 text-sm">
                Group by Department
            </p>
            <p class="text-gray-400 text-sm">
                Group by Technician
            </p>
        </div>

        <!-- Closed Reports -->
        <div class="bg-gray-800 rounded-lg shadow p-5">
            <h3 class="text-lg font-semibold text-white mb-2">Closed Reports</h3>
            <p class="text-gray-400 text-sm">
                View reports by date 7, 30, 60, 90, and a date picker.
            </p>
            <p class="text-gray-400 text-sm">
                Group by Department
            </p>
            <p class="text-gray-400 text-sm">
                Group by Technician
            </p>
        </div>

    </div>
</x-reporting-user-app-layout>
