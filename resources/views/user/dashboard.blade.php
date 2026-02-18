<x-user-app-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Mobile-friendly: 1 col on mobile, 2 cols on lg --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">

                {{-- New panel --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100">New</h3>
                    </div>

                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($ticketsByType['new'] ?? [] as $ticket)
                            <a href="#"
                               class="block p-4 sm:p-5 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                {{-- Mobile: stack title/date + badge; Desktop+: badge on the right --}}
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-4">
                                    <div class="min-w-0">
                                        <div class="font-medium text-gray-900 dark:text-gray-100 break-words">
                                            {{ $ticket->title }}
                                        </div>
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            Created {{ $ticket->created_at->format('M j, Y') }}
                                        </div>
                                    </div>

                                    <span class="self-start sm:self-auto shrink-0 inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $ticket->status_type->badgeColors() }}">
                                        {{ $ticket->status_type->label() }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                                No new tickets.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- In progress panel --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100">In Progress</h3>
                    </div>

                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($ticketsByType['in_progress'] ?? [] as $ticket)
                            <a href="#"
                               class="block p-4 sm:p-5 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-4">
                                    <div class="min-w-0">
                                        <div class="font-medium text-gray-900 dark:text-gray-100 break-words">
                                            {{ $ticket->title }}
                                        </div>
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            Created {{ $ticket->created_at->format('M j, Y') }}
                                        </div>
                                    </div>

                                    <span class="self-start sm:self-auto shrink-0 inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $ticket->status_type->badgeColors() }}">
                                        {{ $ticket->status_type->label() }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                                No tickets in progress.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Completed panel --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100">Completed</h3>
                    </div>

                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($ticketsByType['completed'] ?? [] as $ticket)
                            <a href="#"
                               class="block p-4 sm:p-5 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-4">
                                    <div class="min-w-0">
                                        <div class="font-medium text-gray-900 dark:text-gray-100 break-words">
                                            {{ $ticket->title }}
                                        </div>
                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            Created {{ $ticket->created_at->format('M j, Y') }}
                                        </div>
                                    </div>

                                    <span class="self-start sm:self-auto shrink-0 inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $ticket->status_type->badgeColors() }}">
                                        {{ $ticket->status_type->label() }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                                No completed tickets.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-user-app-layout>
