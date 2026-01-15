<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header + Search + Create Button --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">

                        {{-- Flash Messages --}}
                        <x-flash-message type="success" />

                        <h3 class="text-lg font-semibold">All Tickets</h3>

                        <div class="flex flex-col items-end gap-2">
                            @if (session()->has('create-edit-delete-message'))
                                <div
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-init="setTimeout(() => show = false, 3000)"
                                    class="flex items-center gap-2 rounded-md border
                                        bg-transparent dark:bg-transparent
                                        border-green-600 dark:border-green-400
                                        text-green-700 dark:text-green-400
                                        px-6 py-2"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-4 h-4 shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>

                                    <span class="text-sm font-medium">
                                        {{ session('create-edit-delete-message') }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                                <input
                                    type="text"
                                    wire:model.live="search"
                                    placeholder="Search tickets..."
                                    class="w-full sm:w-64 px-3 py-2 rounded-md border
                                        border-gray-300 dark:border-gray-700
                                        bg-white dark:bg-gray-900 text-sm
                                        focus:outline-none focus:ring focus:ring-blue-500/40"
                                >

                                <x-custom-button href="{{ route('admin.tickets.create') }}" color="blue">
                                    Create Ticket
                                </x-custom-button>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">

                        {{-- TABLE (shown on sm and up) --}}
                        <table class="hidden sm:table min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Submitted By
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Title
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
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($tickets as $ticket)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3">{{ $ticket->submittedBy?->first_name }} {{ $ticket->submittedBy?->last_name }}</td>
                                        <td class="px-4 py-3">{{ $ticket->title }}</td>
                                        <td class="px-4 py-3">{{ $ticket->description }}</td>
                                        <td class="px-4 py-3">{{ $ticket->area }}</td>
                                        <td class="px-4 py-3">{{ $ticket->department }}</td>
                                        <td class="px-4 py-3">{{ $ticket->status }}</td>
                                        <td class="px-4 py-3 space-x-3">
                                            <div class="flex flex-wrap gap-2">
                                                <x-custom-button href="{{ route('admin.tickets.show', $ticket) }}" color="blue">View</x-custom-button>

                                                <x-custom-button
                                                    href="{{ route('admin.tickets.destroy', $ticket) }}"
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
                            @forelse ($tickets as $ticket)
                                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Title:</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $ticket->title }}</span>
                                    </div>

                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Area:</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $ticket->area }}</span>
                                    </div>

                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Department:</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $ticket->department }}</span>
                                    </div>

                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Status:</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $ticket->status }}</span>
                                    </div>

                                    <div class="flex justify-end space-x-3">
                                        <x-custom-button href="{{ route('admin.tickets.show', $ticket) }}" color="blue">View</x-custom-button>

                                        <x-custom-button
                                            href="{{ route('admin.tickets.destroy', $ticket) }}"
                                            method="DELETE"
                                            color="red"
                                        >
                                            Delete
                                        </x-custom-button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 dark:text-gray-400">No ticket tickets found.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $tickets->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
