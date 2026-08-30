<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Models\ActivityLog;
use App\Models\ClientProcessing;
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

    public function publicQueue()
    {
        return view('public.public-queue');
    }

    public function liveQueueData()
    {
        $today = now()->toDateString();

        // Helper: i-map papunta sa SAFE fields lang — walang PII maliban sa masked name
        $mapSafe = function ($processing) {
            return [
                'queue_number' => $processing->queue->queue_number,
                'priority' => (bool) $processing->queue->priority,
                'masked_name' => $processing->client->first_name . ' ' . substr($processing->client->last_name, 0, 1) . '.',
                'client_category' => $processing->client->client_category,
            ];
        };

        // Validation — MERON totoong "Processing" state, kaya totoo ang "Now Serving" dito
        $validationQueue = ClientProcessing::with(['client', 'queue'])
            ->join('queues', 'client_processings.queue_id', '=', 'queues.id')
            ->where('queues.queue_status', '!=', 'Cancelled')
            ->where('client_processings.current_step', 'Validation')
            ->where('client_processings.current_status', 'Processing')
            ->whereDate('client_processings.start_time', $today)
            ->orderBy('queues.priority', 'desc')
            ->orderBy('client_processings.start_time', 'asc')
            ->select('client_processings.*')
            ->get();

        // Assessment/Review/Releasing — WALANG "Processing" state, "Waiting" lang
        // kaya hindi natin ito ilalagay sa "serving" — listahan lang ng "Next in Line"
        $getWaitingForStep = function ($step) use ($today) {
            return ClientProcessing::with(['client', 'queue'])
                ->join('queues', 'client_processings.queue_id', '=', 'queues.id')
                ->where('queues.queue_status', '!=', 'Cancelled')
                ->where('client_processings.current_step', $step)
                ->where('client_processings.current_status', 'Waiting')
                ->whereDate('client_processings.start_time', $today)
                ->orderBy('queues.priority', 'desc')
                ->orderBy('client_processings.start_time', 'asc')
                ->select('client_processings.*')
                ->get();
        };

        $assessmentQueue = $getWaitingForStep('Assessment');
        $reviewQueue = $getWaitingForStep('Review');
        $releasingQueue = $getWaitingForStep('Releasing');

        return response()->json([
            'desks' => [
                'validation' => [
                    'label' => 'DOCUMENT VALIDATION',
                    'counter' => 'Counter 1',
                    'serving' => $validationQueue->take(2)->map($mapSafe)->values(),
                    'upNext' => $validationQueue->slice(2)->take(5)->map($mapSafe)->values(),
                ],
                'assessment' => [
                    'label' => 'INTERVIEW & ASSESSMENT',
                    'counter' => 'Counter 2',
                    'serving' => [],
                    'upNext' => $assessmentQueue->take(5)->map($mapSafe)->values(),
                ],
                'review' => [
                    'label' => 'OFFICER REVIEW',
                    'counter' => 'Counter 3',
                    'serving' => [],
                    'upNext' => $reviewQueue->take(5)->map($mapSafe)->values(),
                ],
                'releasing' => [
                    'label' => 'ASSISTANCE RELEASING',
                    'counter' => 'Counter 4',
                    'serving' => [],
                    'upNext' => $releasingQueue->take(5)->map($mapSafe)->values(),
                ],
            ],
        ]);
    }
}
