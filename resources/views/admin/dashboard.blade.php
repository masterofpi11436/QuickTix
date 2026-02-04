<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $ticketNew = \App\Models\Ticket::where('status_type', \App\Enums\StatusType::New)->count();

        $userId = auth()->id();
        $usersTickets = \App\Models\Ticket::with('assignedTo')
            ->where('assigned_to_user_id', $userId)
            ->whereIn('status_type', [\App\Enums\StatusType::New, \App\Enums\StatusType::InProgress])
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        $usersLoggedInToday = \App\Models\User::whereDate('last_logged_in_at', now()->toDateString())->count();
        $usersOneYearLoggedIn = \App\Models\User::whereDate('last_logged_in_at', now()->subYear()->toDateString())->count();
        $recentTickets = \App\Models\Ticket::with('assignedTo')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total New Tickets</p>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            New: {{ $ticketNew }}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                    <div class="p-6">
                        <p class="text-md font-bold text-gray-500 dark:text-gray-400">Active Users Today</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100"></p>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ $usersLoggedInToday }} users logged in today.
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Users Logged in Over 1 Year Ago</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $usersOneYearLoggedIn }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Recent Tickets</h3>
                        <a href="{{ route('admin.tickets.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            View all
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Assigned To
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                        Created
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($recentTickets as $ticket)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3">
                                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                {{ $ticket->title }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $ticket->status_type->badgeColors() }}">
                                                {{ $ticket->status_type->label() }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ $ticket->assigned_to_name ?? optional($ticket->assignedTo)->name ?? 'Unassigned' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ $ticket->created_at?->format('M j, Y') ?? '—' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                            No tickets yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Tickets Assigned to You</h3>
                    </div>

                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($usersTickets as $ticket)
                            <a href="{{ route('admin.tickets.show', $ticket) }}"
                            class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $ticket->title }}
                                        </div>
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            Created {{ $ticket->created_at->format('M j, Y') }}
                                        </div>
                                    </div>

                                    <span class="shrink-0 inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $ticket->status_type->badgeColors() }}">
                                        {{ $ticket->status_type->label() }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                                No tickets assigned to you.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
