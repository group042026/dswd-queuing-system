<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('access-admin');

        $selectedDate = $request->input('date', now()->format('Y-m-d'));

        $logs = ActivityLog::with('user')
            ->whereDate('time_committed', $selectedDate)
            ->orderBy('time_committed', 'desc')
            ->paginate(10)
            ->appends(['date' => $selectedDate]);

        return view('admin.activitylogs', [
            'logs' => $logs,
            'selectedDate' => $selectedDate,
        ]);
    }
}