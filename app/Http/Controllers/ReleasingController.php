<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
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
    public function releasingData(Request $request)
    {
        Gate::authorize('access-receptionist');

        $selectedDate = $request->input('date', now()->format('Y-m-d'));
        $page = $request->input('page', 1);

        $pendingReleasing = ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Releasing')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $selectedDate)
            ->orderBy('start_time', 'asc')
            ->paginate(10, ['*'], 'page', $page)
            ->withQueryString();

        $isToday = $selectedDate === now()->format('Y-m-d');

        return response()->json([
            'isToday' => $isToday,
            'items' => $pendingReleasing->map(function ($item) {
                return [
                    'id' => $item->id,
                    'queue_number' => $item->queue->queue_number,
                    'full_name' => "{$item->client->first_name} {$item->client->last_name}",
                    'control_number' => $item->client->control_number ?? '',
                    'client_category' => $item->client->client_category,
                    'category_class' => strtolower(str_replace([' ', '/'], ['', '-'], $item->client->client_category)),
                    'program_requested' => $item->client->program_requested,
                    'release_url' => route('receptionist.releasing.release', $item->id),
                ];
            }),
            'pagination' => (string) $pendingReleasing->links(),
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

        event(new DashboardUpdated()); //for real time

        return redirect()->route('receptionist.releasing')->with('success', 'Assistance released successfully.');
    }
}