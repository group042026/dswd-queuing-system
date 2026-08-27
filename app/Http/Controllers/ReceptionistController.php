<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientProcessing;

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

        $completedValidationCount = ClientProcessing::where('current_step', 'Validation')
            ->where('current_status', 'Completed')
            ->whereDate('end_time', $today)
            ->count();

        $pendingReleasingCount = ClientProcessing::where('current_step', 'Releasing')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $today)
            ->count();

        // Pinagsamang Live Queue — Validation AT Releasing
        $liveQueue = ClientProcessing::with(['client', 'queue'])
            ->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->where('current_step', 'Validation')->where('current_status', 'Processing');
                })->orWhere(function ($sub) {
                    $sub->where('current_step', 'Releasing')->where('current_status', 'Waiting');
                });
            })
            ->whereDate('start_time', $today)
            ->orderBy('start_time', 'asc')
            ->paginate(8);

        return view('receptionist.dashboard', [
            'registeredTodayCount' => $registeredTodayCount,
            'pendingValidationCount' => $pendingValidationCount,
            'completedValidationCount' => $completedValidationCount,
            'pendingReleasingCount' => $pendingReleasingCount,
            'liveQueue' => $liveQueue,
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

        $completedValidationCount = ClientProcessing::where('current_step', 'Validation')
            ->where('current_status', 'Completed')
            ->whereDate('end_time', $today)
            ->count();

        $pendingReleasingCount = ClientProcessing::where('current_step', 'Releasing')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $today)
            ->count();

        $liveQueue = ClientProcessing::with(['client', 'queue'])
            ->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->where('current_step', 'Validation')->where('current_status', 'Processing');
                })->orWhere(function ($sub) {
                    $sub->where('current_step', 'Releasing')->where('current_status', 'Waiting');
                });
            })
            ->whereDate('start_time', $today)
            ->orderBy('start_time', 'asc')
            ->limit(8)
            ->get();

        return response()->json([
            'stats' => [
                'registeredTodayCount' => $registeredTodayCount,
                'pendingValidationCount' => $pendingValidationCount,
                'completedValidationCount' => $completedValidationCount,
                'pendingReleasingCount' => $pendingReleasingCount,
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
                    'action_url' => $isValidation ? route('receptionist.validation') : route('receptionist.releasing'),
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
                'category_class' => strtolower(str_replace(' ', '', $item->client->client_category)),
                'program_requested' => $item->client->program_requested,
                'action_label' => $actionLabel,
                'action_url' => $actionUrl,
            ];
        });
    }
}
