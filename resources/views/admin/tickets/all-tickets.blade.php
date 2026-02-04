<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Completed Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="hidden sm:table min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Submitted By</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Title</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Area</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Department</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Completed By</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Completed At</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($completedTickets as $ticket)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3">
                                            {{ $ticket->submittedBy?->first_name }}
                                            {{ $ticket->submittedBy?->last_name }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $ticket->title }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $ticket->area }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $ticket->department }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $ticket->assigned_to_name }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ optional($ticket->completed_at)->format('d M Y') }}
                                        </td>

                                        <td class="px-4 py-3 text-right">
                                            <x-custom-button
                                                href="{{ route('admin.tickets.show', $ticket) }}"
                                                color="blue"
                                            >
                                                View
                                            </x-custom-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                            No completed tickets found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $completedTickets->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
