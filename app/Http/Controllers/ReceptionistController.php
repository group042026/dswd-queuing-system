<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientProcessing;

class ReceptionistController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        // Registered Today
        $registeredTodayCount = Client::whereDate('date_registered', $today)->count();

        // Pending Validations
        $pendingValidationCount = ClientProcessing::where('current_step', 'Validation')
            ->where('current_status', 'Processing')
            ->whereDate('start_time', $today)
            ->count();

        // Completed Validations Today
        $completedValidationCount = ClientProcessing::where('current_step', 'Validation')
            ->where('current_status', 'Completed')
            ->whereDate('end_time', $today)
            ->count();

        // Live Validation Queue (limit to 5 for dashboard overview)
        $liveQueue = ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Validation')
            ->where('current_status', 'Processing')
            ->whereDate('start_time', $today)
            ->orderBy('start_time', 'asc')
            ->paginate(5);
            // ->take(5)
            // ->get();

        return view('receptionist.dashboard', [
            'registeredTodayCount' => $registeredTodayCount,
            'pendingValidationCount' => $pendingValidationCount,
            'completedValidationCount' => $completedValidationCount,
            'liveQueue' => $liveQueue,
        ]);
    }
}
