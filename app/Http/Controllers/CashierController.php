<?php

namespace App\Http\Controllers;

use App\Models\ClientProcessing;
use Illuminate\Support\Facades\Gate;

class CashierController extends Controller
{
    public function index()
    {
        Gate::authorize('access-cashier');

        $today = now()->toDateString();

        $pendingReleasingCount = ClientProcessing::where('current_step', 'Releasing')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $today)
            ->count();

        $releasedTodayCount = ClientProcessing::where('current_step', 'Releasing')
            ->where('current_status', 'Completed')
            ->whereDate('end_time', $today)
            ->count();

        $liveQueue = ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Releasing')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $today)
            ->orderBy('start_time', 'asc')
            ->limit(5)
            ->get();

        return view('cashier.dashboard', [
            'pendingReleasingCount' => $pendingReleasingCount,
            'releasedTodayCount' => $releasedTodayCount,
            'liveQueue' => $liveQueue,
        ]);
    }
}