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
                    'cancellation_reason' => $queue->cancellation_reason,
                ];
            }),
            'pagination' => (string) $queues->links(),
        ]);
    }

    public function cancelQueue(Request $request, Queue $queue)
    {
        Gate::authorize('access-admin');

        $validated = $request->validate([
            'cancellation_reason' => ['required', 'string', 'max:1000'],
        ]);

        $queue->update([
            'queue_status' => 'Cancelled',
            'cancellation_reason' => $validated['cancellation_reason'],
        ]);

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

        // Safe fields lang para sa public queue board
        $mapSafe = function ($processing) {
            return [
                'queue_id' => $processing->queue->id,
                'queue_number' => $processing->queue->queue_number,
                'priority' => (bool) $processing->queue->priority,
                'masked_name' => $processing->client->first_name
                    . ' '
                    . substr($processing->client->last_name, 0, 1)
                    . '.',
                'client_category' => $processing->client->client_category,
                'is_returnee' => (bool) $processing->is_returnee,
                'current_status' => $processing->current_status,
                'is_on_hold' => $processing->current_status === 'On Hold',
            ];
        };

        $validationQueue = ClientProcessing::with(['client', 'queue'])
            ->join('queues', 'client_processings.queue_id', '=', 'queues.id')
            ->where('queues.queue_status', '!=', 'Cancelled')
            ->where('client_processings.current_step', 'Validation')
            ->where('client_processings.current_status', 'Processing')
            ->whereDate('client_processings.start_time', $today)
            ->orderBy('client_processings.start_time', 'asc')
            ->select('client_processings.*')
            ->get();

        $validationRegular = $validationQueue
            ->filter(fn ($item) => !(bool) $item->queue->priority)
            ->values();

        $validationPriority = $validationQueue
            ->filter(fn ($item) => (bool) $item->queue->priority)
            ->values();

        $getQueuesForStep = function ($step) use ($today) {
            $baseQuery = ClientProcessing::with(['client', 'queue'])
                ->join('queues', 'client_processings.queue_id', '=', 'queues.id')
                ->where('queues.queue_status', '!=', 'Cancelled')
                ->where('client_processings.current_step', $step)
                ->whereDate('client_processings.start_time', $today)
                ->select('client_processings.*');

            $waiting = (clone $baseQuery)
                ->where('client_processings.current_status', 'Waiting')
                ->orderBy('client_processings.start_time', 'asc')
                ->get();

            $onHold = (clone $baseQuery)
                ->where('client_processings.current_status', 'On Hold')
                ->orderBy('client_processings.on_hold_at', 'asc')
                ->get();

            return [
                'regular' => [
                    'waiting' => $waiting
                        ->filter(fn ($item) => !(bool) $item->queue->priority)
                        ->values(),

                    'onHold' => $onHold
                        ->filter(fn ($item) => !(bool) $item->queue->priority)
                        ->values(),
                ],

                'priority' => [
                    'waiting' => $waiting
                        ->filter(fn ($item) => (bool) $item->queue->priority)
                        ->values(),

                    'onHold' => $onHold
                        ->filter(fn ($item) => (bool) $item->queue->priority)
                        ->values(),
                ],
            ];
        };

        $assessmentQueues = $getQueuesForStep('Assessment');
        $reviewQueues = $getQueuesForStep('Review');
        $releasingQueues = $getQueuesForStep('Releasing');

        return response()->json([
            'desks' => [
                'validation' => [
                    'label' => 'DOCUMENT VALIDATION',
                    'counter' => 'Counter 1',

                    'regular' => [
                        'serving' => $validationRegular
                            ->take(1)
                            ->map($mapSafe)
                            ->values(),

                        'upNext' => $validationRegular
                            ->slice(1)
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),

                        'onHold' => [],
                    ],

                    'priority' => [
                        'serving' => $validationPriority
                            ->take(1)
                            ->map($mapSafe)
                            ->values(),

                        'upNext' => $validationPriority
                            ->slice(1)
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),

                        'onHold' => [],
                    ],
                ],
                'assessment' => [
                    'label' => 'INTERVIEW & ASSESSMENT',
                    'counter' => 'Counter 2',

                    'regular' => [
                        'serving' => [],
                        'upNext' => $assessmentQueues['regular']['waiting']
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),
                        'onHold' => $assessmentQueues['regular']['onHold']
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),
                    ],

                    'priority' => [
                        'serving' => [],
                        'upNext' => $assessmentQueues['priority']['waiting']
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),
                        'onHold' => $assessmentQueues['priority']['onHold']
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),
                    ],
                ],
                'review' => [
                    'label' => 'OFFICER REVIEW',
                    'counter' => 'Counter 3',

                    'regular' => [
                        'serving' => [],
                        'upNext' => $reviewQueues['regular']['waiting']
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),
                        'onHold' => $reviewQueues['regular']['onHold']
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),
                    ],

                    'priority' => [
                        'serving' => [],
                        'upNext' => $reviewQueues['priority']['waiting']
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),
                        'onHold' => $reviewQueues['priority']['onHold']
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),
                    ],
                ],
                'releasing' => [
                    'label' => 'ASSISTANCE RELEASING',
                    'counter' => 'Counter 4',

                    'regular' => [
                        'serving' => [],
                        'upNext' => $releasingQueues['regular']['waiting']
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),
                        'onHold' => $releasingQueues['regular']['onHold']
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),
                    ],

                    'priority' => [
                        'serving' => [],
                        'upNext' => $releasingQueues['priority']['waiting']
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),
                        'onHold' => $releasingQueues['priority']['onHold']
                            ->take(5)
                            ->map($mapSafe)
                            ->values(),
                    ],
                ],
            ],
        ]);
    }
}
