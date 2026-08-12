<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientProcessing;
use App\Models\Queue;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index()
    {
        Gate::authorize('access-admin');

        $today = now()->toDateString();

        // 1. Queue Stats Today
        $totalQueuesToday = Queue::whereDate('date_issued', $today)->count();
        $servingQueuesToday = Queue::whereDate('date_issued', $today)->where('queue_status', 'Serving')->count();
        $cancelledQueuesToday = Queue::whereDate('date_issued', $today)->where('queue_status', 'Cancelled')->count();

        // Count completed step processing today
        $completedTodayCount = ClientProcessing::whereDate('end_time', $today)
            ->where('current_status', 'Completed')
            ->count();

        // 2. Client Categories Today
        $categoryCounts = Client::whereDate('date_registered', $today)
            ->select('client_category', \DB::raw('count(*) as total'))
            ->groupBy('client_category')
            ->pluck('total', 'client_category')
            ->toArray();

        $seniorsCount = $categoryCounts['Senior'] ?? 0;
        $pwdsCount = $categoryCounts['PWD'] ?? 0;
        $soloParentsCount = $categoryCounts['Solo Parent'] ?? 0;
        $regularsCount = $categoryCounts['Regular'] ?? 0;

        // 3. User distribution
        $totalUsers = User::count();
        $roleCounts = \DB::table('role_user')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->select('roles.role_name', \DB::raw('count(*) as total'))
            ->groupBy('roles.role_name')
            ->pluck('total', 'roles.role_name')
            ->toArray();

        // 4. Recent Processings
        $recentProcessings = ClientProcessing::with(['client', 'queue'])
            ->whereDate('start_time', $today)
            ->orderBy('start_time', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalQueuesToday',
            'servingQueuesToday',
            'cancelledQueuesToday',
            'completedTodayCount',
            'seniorsCount',
            'pwdsCount',
            'soloParentsCount',
            'regularsCount',
            'totalUsers',
            'roleCounts',
            'recentProcessings'
        ));
    }
}
