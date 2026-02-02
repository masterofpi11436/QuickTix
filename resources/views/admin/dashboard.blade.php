<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $ticketTotal = \App\Models\Ticket::count();
        $ticketNew = \App\Models\Ticket::where('status_type', \App\Enums\StatusType::New)->count();
        $ticketInProgress = \App\Models\Ticket::where('status_type', \App\Enums\StatusType::InProgress)->count();
        $ticketCompleted = \App\Models\Ticket::where('status_type', \App\Enums\StatusType::Completed)->count();

        $usersCount = \App\Models\User::count();
        $departmentsCount = \App\Models\Department::count();
        $areasCount = \App\Models\Area::count();

        $allowedDomainsTotal = \App\Models\AllowedDomain::count();
        $allowedDomainsActive = \App\Models\AllowedDomain::where('is_active', true)->count();

        $recentTickets = \App\Models\Ticket::with('assignedTo')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Tickets</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $ticketTotal }}</p>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            New: {{ $ticketNew }} · In Progress: {{ $ticketInProgress }} · Completed: {{ $ticketCompleted }}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Users</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $usersCount }}</p>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Departments: {{ $departmentsCount }} · Areas: {{ $areasCount }}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Allowed Domains</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $allowedDomainsActive }}</p>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Active of {{ $allowedDomainsTotal }}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Quick Actions</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <x-custom-button href="{{ route('admin.tickets.index') }}" color="blue">
                                View Tickets
                            </x-custom-button>
                            <x-custom-button href="{{ route('admin.tickets.create') }}" color="green">
                                New Ticket
                            </x-custom-button>
                            <x-custom-button href="{{ route('admin.administration') }}" color="yellow">
                                Administration
                            </x-custom-button>
                        </div>
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
        </div>
    </div>
</x-admin-app-layout>
