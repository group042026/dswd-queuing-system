<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
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

    public function monitorData(Request $request)
    {
        Gate::authorize('access-admin');

        $selectedDate = $request->input('date', now()->format('Y-m-d'));
        $page = $request->input('page', 1);

        $queues = Queue::with('client', 'client.assessment', 'latestProcessing')
            ->whereDate('date_issued', $selectedDate)
            ->orderBy('priority', 'desc')
            ->orderBy('date_issued', 'asc')
            ->paginate(10, ['*'], 'page', $page)
            ->withQueryString();

        $isToday = $selectedDate === now()->format('Y-m-d');

        return response()->json([
            'isToday' => $isToday,
            'queues' => $queues->map(function ($queue) use ($isToday) {
                return [
                    'id' => $queue->id,
                    'queue_number' => $queue->queue_number,
                    'client_name' => "{$queue->client->first_name} {$queue->client->last_name}",
                    'priority' => $queue->priority,
                    'client_category' => $queue->client->client_category,
                    'current_step' => $queue->latestProcessing?->current_step,
                    'current_status' => $queue->latestProcessing?->current_status,
                    'queue_status' => $queue->queue_status,
                    'date_issued' => $queue->date_issued->format('M d, Y h:i A'),
                    'can_cancel' => $isToday && !in_array($queue->queue_status, ['Completed', 'Cancelled', 'Abondoned']),
                    'cancel_url' => route('admin.queue.cancel', $queue->id),
                ];
            }),
            'pagination' => (string) $queues->links(),
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

        event(new DashboardUpdated());



        return back()->with('success', 'Queue entry cancelled.');
    }
}
