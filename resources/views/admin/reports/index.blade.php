<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Reports') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 space-y-6">

        {{-- KPI row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="rounded-lg shadow p-4 bg-white dark:bg-gray-900">
                <div class="text-xs text-gray-500">New</div>
                <div class="text-2xl font-semibold dark:text-gray-100">{{ $counts['new'] ?? '—' }}</div>
            </div>

            <div class="rounded-lg shadow p-4 bg-white dark:bg-gray-900">
                <div class="text-xs text-gray-500">In Progress</div>
                <div class="text-2xl font-semibold dark:text-gray-100">{{ $counts['in_progress'] ?? '—' }}</div>
            </div>

            <div class="rounded-lg shadow p-4 bg-white dark:bg-gray-900">
                <div class="text-xs text-gray-500">Completed</div>
                <div class="text-2xl font-semibold dark:text-gray-100">{{ $counts['completed'] ?? '—' }}</div>
            </div>

            <div class="rounded-lg shadow p-4 bg-white dark:bg-gray-900">
                <div class="text-xs text-gray-500">Open Total</div>
                <div class="text-2xl font-semibold dark:text-gray-100">{{ $counts['open'] ?? '—' }}</div>
                <div class="text-xs text-gray-500 mt-1">New + In Progress</div>
            </div>

            <div class="rounded-lg shadow p-4 bg-white dark:bg-gray-900">
                <div class="text-xs text-gray-500">Overdue</div>
                <div class="text-2xl font-semibold dark:text-gray-100">{{ $counts['overdue'] ?? '—' }}</div>
                <div class="text-xs text-gray-500 mt-1">&gt; {{ $overdueDays }} days in progress</div>
            </div>
        </div>

        {{-- Middle: breakdowns --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Open by Department --}}
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow">
                <div class="p-4 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
                    <div>
                        <div class="font-semibold dark:text-gray-100">Open by Department</div>
                        <div class="text-xs text-gray-500">Top Departments with Open Work</div>
                    </div>
                    <a href="{{ route('admin.reports.completed-by-department')}}" class="text-sm text-indigo-600 hover:text-indigo-500">View</a>
                </div>

                <div class="p-4">
                    @if(!empty($openByDepartment) && count($openByDepartment))
                        <ul class="space-y-3">
                            @foreach($openByDepartment as $row)
                                <li class="flex items-center justify-between">
                                    <span class="text-sm dark:text-gray-100">{{ $row->department }}</span>
                                    <span class="text-sm font-semibold dark:text-gray-100">{{ $row->total }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-sm text-gray-500">No data.</div>
                    @endif
                </div>
            </div>

            {{-- Open by Technician --}}
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow">
                <div class="p-4 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
                    <div>
                        <div class="font-semibold dark:text-gray-100">Open by Technician</div>
                        <div class="text-xs text-gray-500">Workload Distribution</div>
                    </div>
                    <a href="{{ route('admin.reports.completed-by-tech')}}" class="text-sm text-indigo-600 hover:text-indigo-500">View</a>
                </div>

                <div class="p-4">
                    @if(!empty($openByTech) && count($openByTech))
                        <ul class="space-y-3">
                            @foreach($openByTech as $row)
                                <li class="flex items-center justify-between">
                                    <span class="text-sm dark:text-gray-100">{{ $row->tech }}</span>
                                    <span class="text-sm font-semibold dark:text-gray-100">{{ $row->total }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-sm text-gray-500">No data.</div>
                    @endif
                </div>
            </div>

            {{-- Performance --}}
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow">
                <div class="p-4 border-b border-gray-200 dark:border-gray-800">
                    <div class="font-semibold dark:text-gray-100">Performance</div>
                    <div class="text-xs text-gray-500">Simple Tech Metrics</div>
                </div>

                <div class="p-4 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">Avg time to close</div>
                        <div class="text-sm font-semibold dark:text-gray-100">
                            @if(isset($avgCloseHours) && $avgCloseHours !== null)
                                {{ number_format($avgCloseHours, 1) }} hrs
                            @else
                                ---.--
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">Slowest Average Tech</div>
                        <div class="text-sm font-semibold dark:text-gray-100">
                            @if(isset($slowestAverageTech) && $slowestAverageTech !== null)
                                {{ $slowestAverageTech->assigned_to_name }} ({{ number_format($slowestAverageTech->avg_hours, 1) }} hrs)
                            @else
                                ---.--
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">Fastest Average Tech</div>
                        <div class="text-sm font-semibold dark:text-gray-100">
                            @if(isset($fastestAverageTech) && $fastestAverageTech !== null)
                                {{ $fastestAverageTech->assigned_to_name }} ({{ number_format($fastestAverageTech->avg_hours, 1) }} hrs)
                            @else
                                ---.--
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Trends --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-4">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <div class="font-semibold dark:text-gray-100">Created (Last 30 days)</div>
                        <div class="text-xs text-gray-500">Tickets created per day</div>
                    </div>
                </div>

                <canvas id="createdChart" height="120"></canvas>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-4">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <div class="font-semibold dark:text-gray-100">Completed (Last 30 days)</div>
                        <div class="text-xs text-gray-500">Tickets closed per day</div>
                    </div>
                </div>

                <canvas id="completedChart" height="120"></canvas>
            </div>
        </div>

    </div>

    {{-- Chart.js --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const createdLabels = @json(($createdLast30 ?? collect())->pluck('day'));
            const createdData   = @json(($createdLast30 ?? collect())->pluck('total'));

            const completedLabels = @json(($completedLast30 ?? collect())->pluck('day'));
            const completedData   = @json(($completedLast30 ?? collect())->pluck('total'));

            const createdCtx = document.getElementById('createdChart');
            if (createdCtx) {
                new Chart(createdCtx, {
                    type: 'line',
                    data: {
                        labels: createdLabels,
                        datasets: [{ label: 'Created', data: createdData, tension: 0.3 }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: true } },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }

            const completedCtx = document.getElementById('completedChart');
            if (completedCtx) {
                new Chart(completedCtx, {
                    type: 'line',
                    data: {
                        labels: completedLabels,
                        datasets: [{ label: 'Completed', data: completedData, tension: 0.3 }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: true } },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }
        </script>
    @endpush
</x-admin-app-layout>
