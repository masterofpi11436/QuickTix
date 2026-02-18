<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Completed Tickets by Technician') }}
            </h2>

            <x-custom-button href="{{ route('admin.reports.index') }}" color="green">
                Back to Reports
            </x-custom-button>
        </div>
    </x-slot>

    @php
        $totalTickets = (int) ($completedByTech->sum('total'));
        $techCount = (int) ($completedByTech->count());
        $top = $completedByTech->first();
        $maxTotal = (int) ($completedByTech->max('total') ?? 0);
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Summary --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total completed</div>
                    <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ number_format($totalTickets) }}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Technicians</div>
                    <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ number_format($techCount) }}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Top technician</div>
                    <div class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100 truncate">
                        {{ $top->assigned_to_name ?? '—' }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $top ? number_format($top->total) : 0 }} completed
                    </div>
                </div>
            </div>

            {{-- Ranked table --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="font-semibold text-gray-900 dark:text-gray-100">Breakdown</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Ranked by completed tickets</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Technician</th>
                                <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Completed</th>
                                <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">% of total</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Volume</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($completedByTech as $i => $row)
                                @php
                                    $pct = $totalTickets > 0 ? ($row->total / $totalTickets) * 100 : 0;
                                    $bar = $maxTotal > 0 ? ($row->total / $maxTotal) * 100 : 0;
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="font-medium text-gray-900 dark:text-gray-100 break-words">
                                            {{ $row->assigned_to_name ?? 'Unassigned' }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Rank #{{ $i + 1 }}
                                        </div>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-right font-semibold text-gray-900 dark:text-gray-100">
                                        {{ number_format($row->total) }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-right text-gray-700 dark:text-gray-300">
                                        {{ number_format($pct, 1) }}%
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded h-2">
                                            <div class="bg-indigo-600 h-2 rounded" style="width: {{ $bar }}%"></div>
                                        </div>
                                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            {{ number_format($row->total) }} / {{ number_format($maxTotal) }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                        No completed tickets found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-admin-app-layout>
