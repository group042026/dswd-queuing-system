<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\ClientProcessing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReleasingController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('access-receptionist');

        $selectedDate = $request->input('date', now()->format('Y-m-d'));

        $pendingReleasing = ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Releasing')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $selectedDate)
            ->orderBy('start_time', 'asc')
            ->paginate(10)
            ->appends(['date' => $selectedDate]);

        return view('receptionist.releasing', [
            'pendingReleasing' => $pendingReleasing,
            'selectedDate' => $selectedDate,
        ]);
    }

    public function release(Request $request, ClientProcessing $clientProcessing)
    {
        Gate::authorize('access-receptionist');

        $validated = $request->validate([
            'remarks' => ['nullable', 'string'],
        ]);

        $clientProcessing->update([
            'current_status' => 'Completed',
            'end_time' => now(),
            'remarks' => $validated['remarks'] ?? null,
        ]);

        $clientProcessing->queue->update(['queue_status' => 'Completed']);

        ActivityLog::record(
            'Assistance Released',
            "Released assistance to {$clientProcessing->client->first_name} {$clientProcessing->client->last_name}"
            . ($validated['remarks'] ? " — Remarks: {$validated['remarks']}" : '')
        );

        return redirect()->route('receptionist.releasing')->with('success', 'Assistance released successfully.');
    }
}