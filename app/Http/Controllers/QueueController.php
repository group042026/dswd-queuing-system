<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QueueController extends Controller
{
    public function monitor(Request $request)
    {
        Gate::authorize('access-admin');

        $selectedDate = $request->input('date', now()->format('Y-m-d'));

        $queues = Queue::with('client', 'client.assessment','latestProcessing')
                        ->whereDate('date_issued', $selectedDate)
                        ->orderBy('priority', 'desc')
                        ->orderBy('date_issued', 'asc')
                        ->paginate(10)
                        ->withQueryString();

        return view('admin.queueMonitor', [
            'queues' => $queues,
            'selectedDate' => $selectedDate,
        ]);
    }

    public function cancelQueue(Queue $queue)
    {
        Gate::authorize('access-admin');

        $queue->update(['queue_status' => 'Cancelled']);

        $queue->latestProcessing?->update([
            'current_status' => 'Cancelled',
            'end_time' => now(),
        ]);

        ActivityLog::record(
            'Queue Cancelled',
            "Cancelled queue #{$queue->queue_number} for {$queue->client->first_name} {$queue->client->last_name}"
        );


        return back()->with('success', 'Queue entry cancelled.');
    }
}
