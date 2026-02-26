<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportsController extends Controller
{
public function index(Request $request)
    {
        $now = Carbon::now();
        $overdueDays = 7;
        $overdueCutoff = $now->copy()->subDays($overdueDays);

        $counts = [
            'new' => Ticket::where('status_type', 'new')->count(),
            'in_progress' => Ticket::where('status_type', 'in_progress')->count(),
            'completed' => Ticket::where('status_type', 'completed')->count(),
            'open' => Ticket::whereIn('status_type', ['new','in_progress'])->count(),
            'unassigned' => Ticket::whereIn('status_type', ['new','in_progress'])
                ->whereNull('assigned_to_user_id')
                ->count(),
            'overdue' => Ticket::where('status_type', 'in_progress')
                ->whereNotNull('assigned_at')
                ->where('assigned_at', '<', $overdueCutoff)
                ->count(),
        ];

        $openByDepartment = Ticket::select('department', DB::raw('COUNT(*) as total'))
            ->whereIn('status_type', ['new','in_progress'])
            ->groupBy('department')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $openByTech = Ticket::select(DB::raw("COALESCE(assigned_to_name,'Unassigned') as tech"), DB::raw('COUNT(*) as total'))
            ->whereIn('status_type', ['new','in_progress'])
            ->groupBy('tech')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $avgCloseHours = Ticket::where('status_type', 'completed')
            ->whereNotNull('completed_at')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, completed_at)) as avg_hours'))
            ->value('avg_hours');

        $slowestAverageTech = Ticket::where('status_type', 'completed')
            ->whereNotNull('completed_at')
            ->select('assigned_to_name', DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, completed_at)) as avg_hours'))
            ->groupBy('assigned_to_name')
            ->orderByDesc('avg_hours')
            ->first();

        $fastestAverageTech = Ticket::where('status_type', 'completed')
            ->whereNotNull('completed_at')
            ->select('assigned_to_name', DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, completed_at)) as avg_hours'))
            ->groupBy('assigned_to_name')
            ->orderBy('avg_hours')
            ->first();

        $createdLast30 = Ticket::select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $now->copy()->subDays(30))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $completedLast30 = Ticket::select(DB::raw('DATE(completed_at) as day'), DB::raw('COUNT(*) as total'))
            ->whereNotNull('completed_at')
            ->where('completed_at', '>=', $now->copy()->subDays(30))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return view('controller.reports.index', compact(
            'counts', 'openByDepartment', 'openByTech', 'avgCloseHours', 'slowestAverageTech', 'fastestAverageTech', 'createdLast30', 'completedLast30', 'overdueDays'
        ));
    }

    public function completedTicketByTech(Request $request)
    {
        $query = Ticket::query()
            ->where('status_type', 'completed')
            ->whereNotNull('completed_at');

        $from = null;
        $to   = null;

        // Priority: range > month+year > year > all time
        if ($request->filled('start') || $request->filled('end')) {

            if ($request->filled('start')) {
                $from = Carbon::parse($request->query('start'))->startOfDay();
            }

            if ($request->filled('end')) {
                $to = Carbon::parse($request->query('end'))->addDay()->startOfDay(); // inclusive end
            }

            $filterLabel = trim(($request->query('start') ?: '…') . ' to ' . ($request->query('end') ?: '…'));
        }
        elseif ($request->filled('month') && $request->filled('year')) {

            $year  = (int) $request->query('year');
            $month = (int) $request->query('month');

            $from = Carbon::create($year, $month, 1)->startOfDay();
            $to   = (clone $from)->addMonth();

            $filterLabel = $from->format('F Y');
        }
        elseif ($request->filled('year')) {

            $year = (int) $request->query('year');

            $from = Carbon::create($year, 1, 1)->startOfDay();
            $to   = (clone $from)->addYear();

            $filterLabel = (string) $year;
        }
        else {
            $filterLabel = 'All time';
        }

        if ($from) $query->where('completed_at', '>=', $from);
        if ($to)   $query->where('completed_at', '<',  $to);

        $completedByTech = $query
            ->select('assigned_to_name', DB::raw('COUNT(*) as total'))
            ->groupBy('assigned_to_name')
            ->orderByDesc('total')
            ->get();

        $totalTickets = (int) $completedByTech->sum('total');
        $techCount    = (int) $completedByTech->count();
        $top          = $completedByTech->first();
        $maxTotal     = (int) ($completedByTech->max('total') ?? 0);

        $rows = $completedByTech->values()->map(function ($row, $index) use ($totalTickets, $maxTotal) {
            $total = (int) $row->total;

            return (object) [
                'rank'       => $index + 1,
                'tech'       => $row->assigned_to_name ?: 'Unassigned',
                'total'      => $total,
                'percentage' => $totalTickets > 0 ? round(($total / $totalTickets) * 100, 1) : 0,
                'bar_width'  => $maxTotal > 0 ? round(($total / $maxTotal) * 100, 1) : 0,
            ];
        });

        $years = collect(range(now()->year, now()->year - 10));

        return view('controller.reports.completed-by-tech', [
            'rows'          => $rows,
            'totalTickets'  => $totalTickets,
            'techCount'     => $techCount,
            'top'           => $top,
            'maxTotal'      => $maxTotal,
            'years'         => $years,
            'selectedYear'  => (int) $request->query('year'),
            'selectedMonth' => (int) $request->query('month'),
            'filterLabel'   => $filterLabel,
        ]);
    }

    public function completedTicketByDepartment(Request $request)
    {
        $base = Ticket::query()
            ->where('status_type', 'completed')
            ->whereNotNull('completed_at');

        // -------------------------
        // Infer date filter (same as before)
        // Priority: range > month+year > year > all time
        // -------------------------
        $from = null;
        $to   = null;

        if ($request->filled('start') || $request->filled('end')) {
            if ($request->filled('start')) {
                $from = Carbon::parse($request->query('start'))->startOfDay();
            }
            if ($request->filled('end')) {
                $to = Carbon::parse($request->query('end'))->addDay()->startOfDay(); // inclusive end
            }
            $filterLabel = trim(($request->query('start') ?: '…') . ' to ' . ($request->query('end') ?: '…'));
        } elseif ($request->filled('month') && $request->filled('year')) {
            $year  = (int) $request->query('year');
            $month = (int) $request->query('month');

            $from = Carbon::create($year, $month, 1)->startOfDay();
            $to   = (clone $from)->addMonth(); // exclusive

            $filterLabel = $from->format('F Y');
        } elseif ($request->filled('year')) {
            $year = (int) $request->query('year');

            $from = Carbon::create($year, 1, 1)->startOfDay();
            $to   = (clone $from)->addYear(); // exclusive

            $filterLabel = (string) $year;
        } else {
            $filterLabel = 'All time';
        }

        // -------------------------
        // Department multi-select filter
        // -------------------------
        $selectedDepartments = $request->query('departments', []);
        if (!is_array($selectedDepartments)) {
            $selectedDepartments = [$selectedDepartments];
        }
        $selectedDepartments = array_values(array_filter($selectedDepartments, fn ($v) => $v !== null && $v !== ''));

        // For dropdown options
        $departments = Ticket::query()
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct()
            ->orderBy('department')
            ->pluck('department');

        // -------------------------
        // Apply filters to base for breakdown + totals
        // -------------------------
        $filtered = (clone $base);

        if ($from) $filtered->where('completed_at', '>=', $from);
        if ($to)   $filtered->where('completed_at', '<',  $to);

        if (!empty($selectedDepartments)) {
            $filtered->whereIn('department', $selectedDepartments);
        }

        // Breakdown by department
        $completedByDepartment = $filtered
            ->select('department', DB::raw('COUNT(*) as total'))
            ->groupBy('department')
            ->orderByDesc('total')
            ->get();

        // Summary
        $totalTickets = (int) $completedByDepartment->sum('total');
        $deptCount    = (int) $completedByDepartment->count();
        $top          = $completedByDepartment->first();
        $maxTotal     = (int) ($completedByDepartment->max('total') ?? 0);

        // Table rows with precomputed percentages/bars
        $rows = $completedByDepartment->values()->map(function ($row, $index) use ($totalTickets, $maxTotal) {
            $total = (int) $row->total;

            return (object) [
                'rank'       => $index + 1,
                'department' => $row->department ?: 'Unassigned',
                'total'      => $total,
                'percentage' => $totalTickets > 0 ? round(($total / $totalTickets) * 100, 1) : 0,
                'bar_width'  => $maxTotal > 0 ? round(($total / $maxTotal) * 100, 1) : 0,
            ];
        });

        // Years + current selections for UI
        $years = collect(range(now()->year, now()->year - 10));
        $selectedYear  = $request->filled('year') ? (int) $request->query('year') : null;
        $selectedMonth = $request->filled('month') ? (int) $request->query('month') : null;

        // -------------------------
        // Trend series (same filters; keep "all time" chart reasonable)
        // -------------------------
        $trendFrom = $from;
        $trendTo   = $to;

        if (!$trendFrom && !$trendTo) {
            $trendTo = now()->addDay()->startOfDay();       // exclusive
            $trendFrom = now()->subDays(89)->startOfDay();  // last 90 days
        } else {
            if (!$trendFrom && $trendTo) $trendFrom = (clone $trendTo)->subDays(89);
            if ($trendFrom && !$trendTo) $trendTo = (clone $trendFrom)->addDays(90);
        }

        $days = $trendFrom->diffInDays($trendTo);
        $useMonthly = $days > 120;

        $trendQuery = (clone $base)
            ->where('completed_at', '>=', $trendFrom)
            ->where('completed_at', '<',  $trendTo);

        if (!empty($selectedDepartments)) {
            $trendQuery->whereIn('department', $selectedDepartments);
        }

        if ($useMonthly) {
            $rawTrend = $trendQuery
                ->selectRaw("DATE_FORMAT(completed_at, '%Y-%m') as bucket, COUNT(*) as total")
                ->groupBy('bucket')
                ->orderBy('bucket')
                ->pluck('total', 'bucket');

            $trendLabels = [];
            $trendData   = [];

            $cursor = $trendFrom->copy()->startOfMonth();
            $end    = $trendTo->copy()->startOfMonth();

            while ($cursor < $end) {
                $key = $cursor->format('Y-m');
                $trendLabels[] = $cursor->format('M Y');
                $trendData[]   = (int) ($rawTrend[$key] ?? 0);
                $cursor->addMonth();
            }

            $trendTitle = 'Completed tickets per month';
        } else {
            $rawTrend = $trendQuery
                ->selectRaw("DATE(completed_at) as bucket, COUNT(*) as total")
                ->groupBy('bucket')
                ->orderBy('bucket')
                ->pluck('total', 'bucket');

            $trendLabels = [];
            $trendData   = [];

            $cursor = $trendFrom->copy();
            $end    = $trendTo->copy();

            while ($cursor < $end) {
                $key = $cursor->toDateString();
                $trendLabels[] = $cursor->format('M j');
                $trendData[]   = (int) ($rawTrend[$key] ?? 0);
                $cursor->addDay();
            }

            $trendTitle = 'Completed tickets per day';
        }

        return view('controller.reports.completed-by-department', [
            // table + summary
            'rows'          => $rows,
            'totalTickets'  => $totalTickets,
            'deptCount'     => $deptCount,
            'top'           => $top,
            'maxTotal'      => $maxTotal,

            // filters
            'years'              => $years,
            'selectedYear'       => $selectedYear,
            'selectedMonth'      => $selectedMonth,
            'filterLabel'        => $filterLabel,
            'departments'        => $departments,
            'selectedDepartments'=> $selectedDepartments,

            // trend
            'trendLabels'   => $trendLabels,
            'trendData'     => $trendData,
            'trendTitle'    => $trendTitle,
        ]);
    }
}
