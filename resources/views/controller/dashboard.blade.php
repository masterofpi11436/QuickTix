<x-controller-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $ticketsQuery = \App\Models\Ticket::with('assignedTo');

        $newCount = (clone $ticketsQuery)
            ->where('status_type', \App\Enums\StatusType::New)
            ->count();

        $inProgressCount = (clone $ticketsQuery)
            ->where('status_type', \App\Enums\StatusType::InProgress)
            ->count();

        $unassignedCount = (clone $ticketsQuery)
            ->whereNull('assigned_to_user_id')
            ->whereIn('status_type', [\App\Enums\StatusType::New, \App\Enums\StatusType::InProgress])
            ->count();

        $unassignedTickets = (clone $ticketsQuery)
            ->whereNull('assigned_to_user_id')
            ->whereIn('status_type', [\App\Enums\StatusType::New, \App\Enums\StatusType::InProgress])
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        $inProgressTickets = (clone $ticketsQuery)
            ->where('status_type', \App\Enums\StatusType::InProgress)
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stat cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">New</div>
                    <div class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ $newCount }}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">In Progress</div>
                    <div class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ $inProgressCount }}
                    </div>
                </div>
            </div>

            {{-- Two panels --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Unassigned panel --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Unassigned Tickets</h3>
                    </div>

                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($unassignedTickets as $ticket)
                            <a href="{{ route('controller.tickets.show', $ticket) }}"
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
                                No unassigned tickets.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- In progress panel --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">In Progress</h3>
                    </div>

                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($inProgressTickets as $ticket)
                            <a href="{{ route('controller.tickets.show', $ticket) }}"
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
                                No in-progress tickets.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-controller-app-layout>
