<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                {{-- Header + Search + Create Button --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">
                    <h3 class="text-lg font-semibold">Allowed Domains</h3>

                    <div class="flex flex-col items-end gap-2">
                        <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                            <input
                                type="text"
                                wire:model.live="search"
                                placeholder="Search domains..."
                                class="w-full sm:w-64 px-3 py-2 rounded-md border
                                    border-gray-300 dark:border-gray-700
                                    bg-white dark:bg-gray-900 text-sm
                                    focus:outline-none focus:ring focus:ring-blue-500/40"
                            >

                            <x-custom-button href="{{ route('admin.allowed-domains.create') }}" color="blue">
                                Create Domain
                            </x-custom-button>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="hidden sm:table min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                    Domain
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                    Active
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($allowedDomains as $domain)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-4 py-3">{{ $domain->name }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                            {{ $domain->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200' }}">
                                            {{ $domain->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-2">
                                            <button
                                                type="button"
                                                wire:click="toggleActive({{ $domain->id }})"
                                                class="inline-flex items-center px-3 py-1.5 rounded-md border text-sm
                                                    {{ $domain->is_active ? 'border-gray-300 text-gray-700 dark:border-gray-600 dark:text-gray-200' : 'border-green-600 text-green-700 dark:text-green-200' }}">
                                                {{ $domain->is_active ? 'Disable' : 'Enable' }}
                                            </button>

                                            <x-custom-button href="{{ route('admin.allowed-domains.edit', $domain) }}" color="yellow">
                                                Edit
                                            </x-custom-button>

                                            <x-custom-button
                                                href="{{ route('admin.allowed-domains.destroy', $domain) }}"
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
                                        No domains found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- MOBILE CARD VIEW --}}
                    <div class="sm:hidden space-y-4">
                        @forelse ($allowedDomains as $domain)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">

                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Domain:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $domain->name }}</span>
                                </div>

                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Status:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $domain->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>

                                <div class="flex flex-wrap justify-end gap-2 mt-3">
                                    <button
                                        type="button"
                                        wire:click="toggleActive({{ $domain->id }})"
                                        class="inline-flex items-center px-3 py-1.5 rounded-md border text-sm
                                            {{ $domain->is_active ? 'border-gray-300 text-gray-700 dark:border-gray-600 dark:text-gray-200' : 'border-green-600 text-green-700 dark:text-green-200' }}">
                                        {{ $domain->is_active ? 'Disable' : 'Enable' }}
                                    </button>

                                    <x-custom-button href="{{ route('admin.allowed-domains.edit', $domain) }}" color="yellow">
                                        Edit
                                    </x-custom-button>

                                    <x-custom-button
                                        href="{{ route('admin.allowed-domains.destroy', $domain) }}"
                                        method="DELETE"
                                        color="red"
                                    >
                                        Delete
                                    </x-custom-button>
                                </div>

                            </div>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400">No domains found.</p>
                        @endforelse
                    </div>

                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $allowedDomains->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
