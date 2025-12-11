<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticket Templates') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">Template List</h3>
                        <x-custom-button href="{{ route('admin.tickettemplates.create') }}" color="blue">Create Template</x-custom-button>
                    </div>

                    <div class="overflow-x-auto">

                        {{-- TABLE (shown on sm and up) --}}
                        <table class="hidden sm:table min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Area
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Department
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($tickettemplates as $template)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3">{{ $template->name }}</td>
                                        <td class="px-4 py-3">{{ $template->description }}</td>
                                        <td class="px-4 py-3">{{ $template->area_id }}</td>
                                        <td class="px-4 py-3">{{ $template->description_id }}</td>
                                        <td class="px-4 py-3 space-x-3">
                                            <div class="flex flex-wrap gap-2">
                                                <x-custom-button href="{{ route('admin.tickettemplates.show', $template) }}" color="blue">View</x-custom-button>

                                                <x-custom-button href="{{ route('admin.tickettemplates.edit', $template) }}" color="yellow">Edit</x-custom-button>

                                                <x-custom-button
                                                    href="{{ route('admin.tickettemplates.destroy', $template) }}"
                                                    method="DELETE"
                                                    color="red"
                                                >
                                                    Delete
                                                </x-custom-button>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- MOBILE CARD VIEW (only on < sm) --}}
                        <div class="sm:hidden space-y-4">
                            @forelse ($tickettemplates as $template)
                                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Name:</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $template->name }}</span>
                                    </div>

                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Description:</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $template->description }}</span>
                                    </div>

                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Area:</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $template->area_id }}</span>
                                    </div>

                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Area:</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $template->department_id }}</span>
                                    </div>

                                    <div class="flex justify-end space-x-3">
                                        <x-custom-button href="{{ route('admin.tickettemplates.show', $template) }}" color="blue">View</x-custom-button>

                                        <x-custom-button href="{{ route('admin.tickettemplates.edit', $template) }}" color="yellow">Edit</x-custom-button>

                                        <x-custom-button
                                            href="{{ route('admin.tickettemplates.destroy', $template) }}"
                                            method="DELETE"
                                            color="red"
                                        >
                                            Delete
                                        </x-custom-button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 dark:text-gray-400">No ticket templates found.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $tickettemplates->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
