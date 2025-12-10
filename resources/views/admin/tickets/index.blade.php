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

                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">Ticket List</h3>

                        <a
                            href="{{ route('admin.tickets.create') }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded-md text-sm"
                        >
                            Create Ticket
                        </a>
                    </div>

                    <div class="overflow-x-auto">

                        {{-- TABLE (shown on sm and up) --}}
                        <table class="hidden sm:table min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
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
                                        <td class="px-4 py-3">{{ $ticket->title }}</td>
                                        <td class="px-4 py-3">{{ $ticket->description }}</td>
                                        <td class="px-4 py-3">{{ $ticket->area }}</td>
                                        <td class="px-4 py-3">{{ $ticket->department }}</td>
                                        <td class="px-4 py-3">{{ $ticket->status }}</td>
                                        <td class="px-4 py-3 space-x-3">
                                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-blue-600 dark:text-blue-400 hover:underline">View</a>
                                            <a href="{{ route('admin.tickets.edit', $ticket) }}" class="text-yellow-600 dark:text-yellow-400 hover:underline">Edit</a>
                                            <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="inline" onsubmit="return confirm('Delete this ticket?');">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600 dark:text-red-400 hover:underline">Delete</button>
                                            </form>
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
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Name:</span>
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
                                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-blue-600 dark:text-blue-400 hover:underline">View</a>
                                        <a href="{{ route('admin.tickets.edit', $ticket) }}" class="text-yellow-600 dark:text-yellow-400 hover:underline">Edit</a>
                                        <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('Delete this ticket?');">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 dark:text-red-400 hover:underline">Delete</button>
                                        </form>
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
