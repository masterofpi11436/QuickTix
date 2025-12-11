<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                {{-- Header + Search + Create Button --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">
                    <h3 class="text-lg font-semibold">Department List</h3>

                    <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                        <input
                            type="text"
                            wire:model.live="search"
                            placeholder="Search departments..."
                            class="w-full sm:w-64 px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:outline-none focus:ring focus:ring-blue-500/40"
                        >

                        <x-custom-button href="{{ route('admin.departments.create') }}" color="blue">
                            Create Department
                        </x-custom-button>
                    </div>
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
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($departments as $department)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-4 py-3">{{ $department->name }}</td>
                                    <td class="px-4 py-3">{{ $department->description }}</td>

                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-2">
                                            <x-custom-button href="{{ route('admin.departments.show', $department) }}" color="blue">
                                                View
                                            </x-custom-button>

                                            <x-custom-button href="{{ route('admin.departments.edit', $department) }}" color="yellow">
                                                Edit
                                            </x-custom-button>

                                            <x-custom-button
                                                href="{{ route('admin.departments.destroy', $department) }}"
                                                method="DELETE"
                                                color="red"
                                            >
                                                Delete
                                            </x-custom-button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                        No departments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- MOBILE CARD VIEW (only on < sm) --}}
                    <div class="sm:hidden space-y-4">
                        @forelse ($departments as $department)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Name:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $department->name }}</span>
                                </div>

                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Description:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $department->description }}</span>
                                </div>

                                <div class="flex flex-wrap justify-end gap-2 mt-3">
                                    <x-custom-button href="{{ route('admin.departments.show', $department) }}" color="blue">
                                        View
                                    </x-custom-button>

                                    <x-custom-button href="{{ route('admin.departments.edit', $department) }}" color="yellow">
                                        Edit
                                    </x-custom-button>

                                    <x-custom-button
                                        href="{{ route('admin.departments.destroy', $department) }}"
                                        method="DELETE"
                                        color="red"
                                    >
                                        Delete
                                    </x-custom-button>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400">No departments found.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mt-4">
                    {{ $departments->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
