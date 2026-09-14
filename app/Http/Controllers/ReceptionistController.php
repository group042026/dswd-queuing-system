<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\ClientProcessing;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ReceptionistController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $registeredTodayCount = Client::whereDate('date_registered', $today)->count();

        $pendingValidationCount = ClientProcessing::where('current_step', 'Validation')
            ->where('current_status', 'Processing')
            ->whereDate('start_time', $today)
            ->count();

        $pendingOnlineRegistrationsCount = Queue::where('queue_status',  'Pending Arrival')
            ->count();

        $completedValidationCount = ClientProcessing::where('current_step', 'Validation')
            ->where('current_status', 'Completed')
            ->whereDate('end_time', $today)
            ->count();

        // $pendingReleasingCount = ClientProcessing::where('current_step', 'Releasing')
        //     ->where('current_status', 'Waiting')
        //     ->whereDate('start_time', $today)
        //     ->count();

        // Pinagsamang Live Queue — Validation AT Releasing
        // $liveQueue = ClientProcessing::with(['client', 'queue'])
        //     ->where(function ($q) {
        //         $q->where(function ($sub) {
        //             $sub->where('current_step', 'Validation')->where('current_status', 'Processing');
        //         })->orWhere(function ($sub) {
        //             $sub->where('current_step', 'Releasing')->where('current_status', 'Waiting');
        //         });
        //     })
        //     ->whereDate('start_time', $today)
        //     ->orderBy('start_time', 'asc')
        //     ->paginate(8);

        $liveQueue = ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Validation')
            ->where('current_status', 'Processing')
            ->whereDate('start_time', $today)
            ->orderBy('start_time', 'asc')
            ->paginate(8);


        return view('receptionist.dashboard', [
            'registeredTodayCount' => $registeredTodayCount,
            'pendingValidationCount' => $pendingValidationCount,
            'completedValidationCount' => $completedValidationCount,
            // 'pendingReleasingCount' => $pendingReleasingCount,
            'liveQueue' => $liveQueue,
            'pendingOnlineRegistrationsCount' => $pendingOnlineRegistrationsCount,
        ]);
    }

    public function dashboardData()
    {
        $today = now()->toDateString();

        $registeredTodayCount = Client::whereDate('date_registered', $today)->count();

        $pendingValidationCount = ClientProcessing::where('current_step', 'Validation')
            ->where('current_status', 'Processing')
            ->whereDate('start_time', $today)
            ->count();
        $pendingOnlineRegistrationsCount = Queue::where('queue_status', 'Pending Arrival')
            ->count();

        $completedValidationCount = ClientProcessing::where('current_step', 'Validation')
            ->where('current_status', 'Completed')
            ->whereDate('end_time', $today)
            ->count();

        // $pendingReleasingCount = ClientProcessing::where('current_step', 'Releasing')
        //     ->where('current_status', 'Waiting')
        //     ->whereDate('start_time', $today)
        //     ->count();

        // $liveQueue = ClientProcessing::with(['client', 'queue'])
        //     ->where(function ($q) {
        //         $q->where(function ($sub) {
        //             $sub->where('current_step', 'Validation')->where('current_status', 'Processing');
        //         })->orWhere(function ($sub) {
        //             $sub->where('current_step', 'Releasing')->where('current_status', 'Waiting');
        //         });
        //     })
        //     ->whereDate('start_time', $today)
        //     ->orderBy('start_time', 'asc')
        //     ->limit(8)
        //     ->get();

        $liveQueue = ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Validation')
            ->where('current_status', 'Processing')
            ->whereDate('start_time', $today)
            ->orderBy('start_time', 'asc')
            ->paginate(8);

        return response()->json([
            'stats' => [
                'registeredTodayCount' => $registeredTodayCount,
                'pendingValidationCount' => $pendingValidationCount,
                'completedValidationCount' => $completedValidationCount,
                // 'pendingReleasingCount' => $pendingReleasingCount,
                'pendingOnlineRegistrationsCount' => $pendingOnlineRegistrationsCount,
            ],
            'liveQueue' => $liveQueue->map(function ($item) {
                $isValidation = $item->current_step === 'Validation';

                return [
                    'queue_number' => $item->queue->queue_number,
                    'full_name' => "{$item->client->first_name} {$item->client->last_name}",
                    'control_number' => $item->client->control_number,
                    'client_category' => $item->client->client_category,
                    'category_class' => strtolower(str_replace(' ', '', $item->client->client_category)),
                    'program_requested' => $item->client->program_requested,
                    'step_label' => $item->current_step,
                    'step_class' => $isValidation ? 'step-badge--validation' : 'step-badge--releasing',
                    'action_label' => $isValidation ? 'Validate Docs' : 'Release',
                    // 'action_url' => $isValidation ? route('receptionist.validation') : route('approving-officer.releasing'),
                    'action_url' => route('receptionist.validation'),
                ];
            }),
        ]);
    }

    private function mapQueueItems($items, string $actionLabel, string $actionUrl)
    {
        return $items->map(function ($item) use ($actionLabel, $actionUrl) {
            return [
                'queue_number' => $item->queue->queue_number,
                'full_name' => "{$item->client->first_name} {$item->client->last_name}",
                'control_number' => $item->client->control_number,
                'client_category' => $item->client->client_category,
                'category_class' => strtolower(
                    str_replace([' ', '/'], ['', '-'], $item->client->client_category)
                ),

                'program_requested' => $item->client->program_requested,
                'action_label' => $actionLabel,
                'action_url' => $actionUrl,
            ];
        });
    }

    public function onlineRegistrations()
    {
        Gate::authorize('access-receptionist');

        $onlineRegistrations = Queue::with([
            'client.documents',
        ])
            ->where('queue_status', 'Pending Arrival')
            ->orderByDesc('priority')
            ->orderBy('date_issued')
            ->paginate(10);

        return view('receptionist.online-registrations', [
            'onlineRegistrations' => $onlineRegistrations,
        ]);
    }

    public function onlineRegistrationsData()
    {
        Gate::authorize('access-receptionist');

        $registrations = Queue::with(['client.documents'])
            ->where('queue_status', 'Pending Arrival')
            ->orderByDesc('priority')
            ->orderBy('date_issued')
            ->get();

        return response()->json([
            'registrations' => $registrations->map(function ($queue) {
                return [
                    'id' => $queue->id,
                    'queue_number' => $queue->queue_number,
                    'priority' => $queue->priority,
                    'client_name' => "{$queue->client->first_name} {$queue->client->last_name}",
                    'control_number' => $queue->client->control_number,
                    'client_category' => $queue->client->client_category,
                    'contact_number' => $queue->client->contact_number,
                    'documents_count' => $queue->client->documents->count(),
                    'verified_documents_count' => $queue->client->documents
                        ->where('verified', true)
                        ->count(),
                    'date_issued' => $queue->date_issued?->format('M d, Y h:i A'),
                ];
            }),
        ]);
    }

    public function confirmOnlineArrival(Queue $queue)
    {
        Gate::authorize('access-receptionist');

        DB::transaction(function () use ($queue) {
            $lockedQueue = Queue::query()
                ->lockForUpdate()
                ->with('client')
                ->findOrFail($queue->id);

            if ($lockedQueue->queue_status !== 'Pending Arrival') {
                abort(409, 'This online registration has already been processed.');
            }

            $lockedQueue->update([
                'queue_status' => 'Serving',
            ]);

            ClientProcessing::create([
                'client_id' => $lockedQueue->client_id,
                'user_id' => auth()->id(),
                'queue_id' => $lockedQueue->id,
                'current_step' => 'Validation',
                'current_status' => 'Processing',
                'start_time' => now(),
            ]);

            ActivityLog::record(
                'Online Registration Confirmed',
                "Confirmed arrival of online client {$lockedQueue->client->first_name} {$lockedQueue->client->last_name} " .
                "(Control #: {$lockedQueue->client->control_number}, Queue #: {$lockedQueue->queue_number})"
            );

            event(new DashboardUpdated());
        });

        return redirect()
            ->route('receptionist.validation')
            ->with('success', 'Client arrival confirmed and moved to validation.');
    }
}
