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
}
