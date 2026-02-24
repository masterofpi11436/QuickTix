{{-- resources/views/admin/reports/completed-by-department.blade.php --}}

<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Completed Tickets by Department') }}
                </h2>
                <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Showing:
                    <span class="font-medium text-gray-700 dark:text-gray-200">{{ $filterLabel }}</span>
                </div>
            </div>

            <x-custom-button href="{{ route('admin.reports.index') }}" color="green">
                Back to Reports
            </x-custom-button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Filters --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 sm:p-6">
                <form method="GET" action="{{ route('admin.reports.completed-by-department') }}" class="space-y-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Select departments (optional) and/or choose a time window, then click <span class="font-semibold">Apply</span>.
                        Priority is <span class="font-semibold">Custom range</span> → <span class="font-semibold">Month+Year</span> → <span class="font-semibold">Year</span> → <span class="font-semibold">All time</span>.
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        {{-- Departments (multi-select) --}}
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4 md:col-span-1">
                            <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm mb-3">Departments</div>

                            <select name="departments[]" multiple
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 h-40">
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept }}" {{ in_array($dept, $selectedDepartments, true) ? 'selected' : '' }}>
                                        {{ $dept }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                Hold Ctrl (Windows) / Cmd (Mac) for multiple.
                            </div>
                        </div>

                        {{-- Custom range --}}
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm mb-3">Custom range</div>

                            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Start date</label>
                            <input type="date" name="start" value="{{ request('start') }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">

                            <label class="block text-xs text-gray-500 dark:text-gray-400 mt-3 mb-1">End date</label>
                            <input type="date" name="end" value="{{ request('end') }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        </div>

                        {{-- Month --}}
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm mb-3">Month</div>

                            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Month</label>
                            <select name="month"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                <option value="">—</option>
                                <option value="1"  {{ $selectedMonth === 1  ? 'selected' : '' }}>January</option>
                                <option value="2"  {{ $selectedMonth === 2  ? 'selected' : '' }}>February</option>
                                <option value="3"  {{ $selectedMonth === 3  ? 'selected' : '' }}>March</option>
                                <option value="4"  {{ $selectedMonth === 4  ? 'selected' : '' }}>April</option>
                                <option value="5"  {{ $selectedMonth === 5  ? 'selected' : '' }}>May</option>
                                <option value="6"  {{ $selectedMonth === 6  ? 'selected' : '' }}>June</option>
                                <option value="7"  {{ $selectedMonth === 7  ? 'selected' : '' }}>July</option>
                                <option value="8"  {{ $selectedMonth === 8  ? 'selected' : '' }}>August</option>
                                <option value="9"  {{ $selectedMonth === 9  ? 'selected' : '' }}>September</option>
                                <option value="10" {{ $selectedMonth === 10 ? 'selected' : '' }}>October</option>
                                <option value="11" {{ $selectedMonth === 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ $selectedMonth === 12 ? 'selected' : '' }}>December</option>
                            </select>

                            <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                Uses the Year selector.
                            </div>
                        </div>

                        {{-- Year --}}
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm mb-3">Year</div>

                            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Year</label>
                            <select name="year"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                <option value="">—</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ $selectedYear === $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit"
                                class="px-4 py-2 rounded-md bg-indigo-600 text-white text-sm font-semibold">
                            Apply
                        </button>

                        <a href="{{ route('admin.reports.completed-by-department') }}"
                           class="text-sm text-gray-600 dark:text-gray-300 underline">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Summary --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total completed</div>
                    <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ number_format($totalTickets) }}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Departments</div>
                    <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ number_format($deptCount) }}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Top department</div>
                    <div class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100 truncate">
                        {{ $top->department ?? '—' }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $top ? number_format($top->total) : 0 }} completed
                    </div>
                </div>
            </div>

            {{-- Breakdown table --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="font-semibold text-gray-900 dark:text-gray-100">Breakdown</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Ranked by completed tickets</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                                <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Completed</th>
                                <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">% of total</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Volume</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($rows as $row)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="font-medium text-gray-900 dark:text-gray-100 break-words">
                                            {{ $row->department }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Rank #{{ $row->rank }}
                                        </div>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-right font-semibold text-gray-900 dark:text-gray-100">
                                        {{ number_format($row->total) }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-right text-gray-700 dark:text-gray-300">
                                        {{ number_format($row->percentage, 1) }}%
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded h-2">
                                            <div class="bg-indigo-600 h-2 rounded" style="width: {{ $row->bar_width }}%"></div>
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

            {{-- Trend chart --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="font-semibold text-gray-900 dark:text-gray-100">Trend</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $trendTitle }}</div>
                </div>

                <div class="p-4 sm:p-6">
                    <div class="w-full" style="height: 320px;">
                        <canvas id="completedDeptTrend"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            const el = document.getElementById('completedDeptTrend');
            if (!el) return;

            const labels = @json($trendLabels);
            const data = @json($trendData);

            if (window.__completedDeptTrendChart) {
                window.__completedDeptTrendChart.destroy();
            }

            window.__completedDeptTrendChart = new Chart(el, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Completed',
                        data,
                        tension: 0.25,
                        fill: false,
                        pointRadius: 0,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: true },
                        tooltip: { enabled: true }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });
        })();
    </script>
</x-admin-app-layout>