<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Models\ActivityLog;
use App\Models\ClientProcessing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApprovingOfficerController extends Controller
{
    public function index()
    {
        Gate::authorize('access-approving-officer');

        $today = now()->toDateString();

        // Pending Reviews
        $pendingReviewCount = ClientProcessing::where('current_step', 'Review')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $today)
            ->count();

        // Approved Today
        $approvedTodayCount = ClientProcessing::where('current_step', 'Review')
            ->where('current_status', 'Completed')
            ->whereHas('client.assessment', function ($q) use ($today) {
                $q->where('approval_status', 'Approved')
                    ->whereDate('approved_at', $today);
            })
            ->count();

        // Returned Today
        $returnedTodayCount = ClientProcessing::where('current_step', 'Review')
            ->where('current_status', 'Completed')
            ->whereHas('client.assessment', function ($q) use ($today) {
                $q->where('approval_status', 'Returned')
                    ->whereDate('approved_at', $today);
            })
            ->count();

        // Live Review Queue (limit to 5)
        $liveQueue = ClientProcessing::with(['client', 'queue', 'client.assessment'])
            ->where('current_step', 'Review')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $today)
            ->orderBy('start_time', 'asc')
            ->paginate(5);


        return view('approving-officer.dashboard', [
            'pendingReviewCount' => $pendingReviewCount,
            'approvedTodayCount' => $approvedTodayCount,
            'returnedTodayCount' => $returnedTodayCount,
            'liveQueue' => $liveQueue,
        ]);
    }

    public function dashboardData()
    {
        Gate::authorize('access-approving-officer');

        $today = now()->toDateString();

        $pendingReviewCount = ClientProcessing::where('current_step', 'Review')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $today)
            ->count();

        $approvedTodayCount = ClientProcessing::where('current_step', 'Review')
            ->where('current_status', 'Completed')
            ->whereHas('client.assessment', function ($q) use ($today) {
                $q->where('approval_status', 'Approved')
                    ->whereDate('approved_at', $today);
            })
            ->count();

        $returnedTodayCount = ClientProcessing::where('current_step', 'Review')
            ->where('current_status', 'Completed')
            ->whereHas('client.assessment', function ($q) use ($today) {
                $q->where('approval_status', 'Returned')
                    ->whereDate('approved_at', $today);
            })
            ->count();

        $liveQueue = ClientProcessing::with(['client', 'queue', 'client.assessment'])
            ->where('current_step', 'Review')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $today)
            ->orderBy('start_time', 'asc')
            ->limit(5)
            ->get();

        return response()->json([
            'stats' => [
                'pendingReviewCount' => $pendingReviewCount,
                'approvedTodayCount' => $approvedTodayCount,
                'returnedTodayCount' => $returnedTodayCount,
            ],
            'liveQueue' => $liveQueue->map(function ($item) {
                return [
                    'queue_number' => $item->queue->queue_number,
                    'full_name' => "{$item->client->first_name} {$item->client->last_name}",
                    'control_number' => $item->client->control_number,
                    'client_category' => $item->client->client_category,
                    // 'category_class' => strtolower(str_replace(' ', '', $item->client->client_category)),
                    'category_class' => strtolower(
                        str_replace([' ', '/'], ['', '-'], $item->client->client_category)
                    ),
                    'program_requested' => $item->client->program_requested,
                ];
            }),
        ]);
    }
    
    public function pendingReview(Request $request)
    {
        Gate::authorize('access-approving-officer');

        $selectedDate = $request->input('date', now()->format('Y-m-d'));

        $pendingReview = ClientProcessing::with(['client', 'queue', 'client.assessment'])
            ->where('current_step', 'Review')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $selectedDate)
            ->orderBy('start_time', 'asc')
            ->paginate(10)
            ->appends(['date' => $selectedDate]);

        return view('approving-officer.review', [
            'pendingReview' => $pendingReview,
            'selectedDate' => $selectedDate,
        ]);
    }

    public function decide(Request $request, ClientProcessing $clientProcessing)
    {
        Gate::authorize('access-approving-officer');

        $validated = $request->validate([
            'decision' => ['required', 'in:Approved,Returned'],
            'approval_remarks' => ['required', 'string'],
        ]);

        $assessment = $clientProcessing->client->assessment;
        $client = $clientProcessing->client;
        
        $assessment->update([
            'approving_officer_id' => auth()->id(),
            'approval_status' => $validated['decision'],
            'approval_remarks' => $validated['approval_remarks'],
            'approved_at' => now(),
        ]);

        $clientProcessing->update([
            'current_status' => 'Completed',
            'end_time' => now(),
        ]);

        if ($validated['decision'] === 'Approved') {
            ClientProcessing::create([
                'client_id' => $clientProcessing->client_id,
                'user_id' => auth()->id(),
                'queue_id' => $clientProcessing->queue_id,
                'current_step' => 'Releasing',
                'current_status' => 'Waiting',
                'start_time' => now(),
            ]);

            ActivityLog::record(
                'Application Approved',
                "Approved application for {$client->first_name} {$client->last_name} — moved to Releasing stage. Remarks: {$validated['approval_remarks']}"
            );

            $message = 'Application approved. Client moved to Releasing stage.';
        } else {
            // WALANG bagong ClientProcessing dito — mananatili sa "Returned" state
            // hanggang i-resume ni Social Worker mismo

            ActivityLog::record(
                'Application Returned',
                "Returned application for {$client->first_name} {$client->last_name} to Social Worker. Remarks: {$validated['approval_remarks']}"
            );

            $message = 'Application returned to Social Worker.';
        }

        event(new DashboardUpdated()); //for real time

        return redirect()->route('approving-officer.review')->with('success', $message);
    }
}
