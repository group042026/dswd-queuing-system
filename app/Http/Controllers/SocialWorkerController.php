<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Models\ActivityLog;
use App\Models\Assessment;
use App\Models\ClientProcessing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;

class SocialWorkerController extends Controller
{
    public function index()
    {
        Gate::authorize('access-social-worker');

        $today = now()->toDateString();

        // Pending Assessments
        $pendingAssessmentCount = ClientProcessing::where('current_step', 'Assessment')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $today)

            ->count();

        // Completed Assessments Today
        $completedAssessmentCount = ClientProcessing::where('current_step', 'Assessment')
            ->where('current_status', 'Completed')
            ->whereDate('end_time', $today)
            ->count();

        // Returned Assessments Count (all active returned assessments in Review step)
        $returnedAssessmentCount = ClientProcessing::where('current_step', 'Review')
            ->where('current_status', 'Completed')
            ->whereHas('client.assessment', function ($q) {
                $q->where('approval_status', 'Returned');
            })
            ->count();

        // Live Assessment Queue (limit to 5)
        $liveQueue = ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Assessment')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $today)
            ->orderBy('start_time', 'asc')
            ->paginate(4);
            // ->take(5)
            // ->get();

        return view('social-worker.dashboard', [
            'pendingAssessmentCount' => $pendingAssessmentCount,
            'completedAssessmentCount' => $completedAssessmentCount,
            'returnedAssessmentCount' => $returnedAssessmentCount,
            'liveQueue' => $liveQueue,
        ]);
    }

    public function dashboardData()
    {
        Gate::authorize('access-social-worker');

        $today = now()->toDateString();

        $pendingAssessmentCount = ClientProcessing::where('current_step', 'Assessment')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $today)
            ->count();

        $completedAssessmentCount = ClientProcessing::where('current_step', 'Assessment')
            ->where('current_status', 'Completed')
            ->whereDate('end_time', $today)
            ->count();

        $returnedAssessmentCount = ClientProcessing::where('current_step', 'Review')
            ->where('current_status', 'Completed')
            ->whereHas('client.assessment', function ($q) {
                $q->where('approval_status', 'Returned');
            })
            ->count();

        $liveQueue = ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Assessment')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $today)
            ->orderBy('start_time', 'asc')
            ->limit(4)
            ->get();

        return response()->json([
            'stats' => [
                'pendingAssessmentCount' => $pendingAssessmentCount,
                'completedAssessmentCount' => $completedAssessmentCount,
                'returnedAssessmentCount' => $returnedAssessmentCount,
            ],
            'liveQueue' => $liveQueue->map(function ($item) {
                return [
                    'queue_number' => $item->queue->queue_number,
                    'full_name' => "{$item->client->first_name} {$item->client->last_name}",
                    'control_number' => $item->client->control_number,
                    'client_category' => $item->client->client_category,
                    'category_class' => strtolower(
                        str_replace([' ', '/'], ['', '-'], $item->client->client_category)
                    ),
                    'program_requested' => $item->client->program_requested,
                ];
            }),
        ]);
    }

    public function pendingAssessment(Request $request)
    {
        Gate::authorize('access-social-worker');

        $selectedDate = $request->input('date', now()->format('Y-m-d'));

        $pendingAssessment = ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Assessment')
            ->where('current_status', 'Waiting')
            ->whereDate('start_time', $selectedDate)
            ->orderBy('start_time', 'asc')
            ->paginate(10)
            ->appends(['date' => $selectedDate]);

        return view('social-worker.assessment', [
            'pendingAssessment' => $pendingAssessment,
            'selectedDate' => $selectedDate,
        ]);
    }

    public function storeAssessment(Request $request, ClientProcessing $clientProcessing)
    {
        Gate::authorize('access-social-worker');

        $movDocument = $clientProcessing->client->documents
            ->firstWhere('document_name', 'Means of Verification (MOV)');

        if (! $movDocument) {
            return back()->withErrors([
                'means_verification' => 'No MOV photo found for this client. Please have the Receptionist capture it first.',
            ]);
        }

        $validated = $request->validate([
            'remarks' => ['nullable', 'string'],
        ]);

        $validated['means_verification'] = $movDocument->file_path;
        $validated['client_id'] = $clientProcessing->client_id;
        $validated['social_worker_id'] = auth()->id();
        $validated['assessment_status'] = 'Completed';
        $validated['interview_date'] = $clientProcessing->client->date_registered;

        Assessment::create($validated);

        $clientProcessing->update([
            'current_status' => 'Completed',
            'end_time' => now(),
        ]);

        ClientProcessing::create([
            'client_id' => $clientProcessing->client_id,
            'user_id' => auth()->id(),
            'queue_id' => $clientProcessing->queue_id,
            'current_step' => 'Review',
            'current_status' => 'Waiting',
            'start_time' => now(),
            'is_returnee' => $clientProcessing->is_returnee,

        ]);

        ActivityLog::record(
            'Assessment Completed',
            "Completed assessment for {$clientProcessing->client->first_name} {$clientProcessing->client->last_name}"
        );

        event(new DashboardUpdated());

        return redirect()->route('social-worker.assessment')->with('success', 'Assessment completed. Client moved to Review stage.');
    }

    public function returnedAssessments(Request $request)
    {
        Gate::authorize('access-social-worker');

        // $selectedDate = $request->input('date', now()->format('Y-m-d'));

        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        $returned = ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Review')
            ->where('current_status', 'Completed')
            ->whereDate('start_time', '>=', $dateFrom)
            ->whereDate('end_time', '<=', $dateTo)
            ->whereHas('client.assessment', function ($q) {
                $q->where('approval_status', 'Returned');
            })
            ->whereIn('id', function ($query) {
            // Only return latest Review row per client
                $query->selectRaw('MAX(id)')
                    ->from('client_processings')
                    ->where('current_step', 'Review')
                    ->groupBy('client_id');
            })
            ->orderBy('end_time', 'desc')
            ->paginate(10)
            ->appends(['date_from' => $dateFrom, 'date_to' => $dateTo]);

        return view('social-worker.returned', 
                ['returned' => $returned, 
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo
        ]);
    }

    // public function resumeAssessment(ClientProcessing $clientProcessing)
    // {
    //     Gate::authorize('access-social-worker');

    //     $assessment = $clientProcessing->client->assessment;
    //     $assessment->update(['approval_status' => 'Resumed']);

    //     ClientProcessing::create([
    //         'client_id' => $clientProcessing->client_id,
    //         'user_id' => auth()->id(),
    //         'queue_id' => $clientProcessing->queue_id,
    //         'current_step' => 'Assessment',
    //         'current_status' => 'Waiting',
    //         'start_time' => now(),
    //     ]);

    //     ActivityLog::record(
    //         'Assessment Resumed',
    //         "Resumed assessment for {$clientProcessing->client->first_name} {$clientProcessing->client->last_name} — moved back to Pending Assessment"
    //     );

    //     event(new DashboardUpdated()); //for real time

    //     return redirect()->route('social-worker.returned')->with('success', 'Client moved back to Pending Assessment.');
    // }

    public function onHold(Request $request, ClientProcessing $clientProcessing)
    {
        Gate::authorize('access-social-worker');

        abort_unless(
            $clientProcessing->current_step === 'Assessment'
            && $clientProcessing->current_status === 'Waiting',
            422
        );

        $validated = $request->validate([
            'on_hold_reason' => ['required', 'string', 'max:1000'],
        ]);

        $clientProcessing->update([
            'current_status' => 'On Hold',
            'on_hold_reason' => $validated['on_hold_reason'],
            'on_hold_at' => now(),
        ]);

        ActivityLog::record(
            'Assessment Put On Hold',
            "Put {$clientProcessing->client->first_name} {$clientProcessing->client->last_name} on hold. Reason: {$validated['on_hold_reason']}"
        );

        event(new DashboardUpdated());

        return back()->with('success', 'Client was placed on hold.');
    }

    public function onHoldAssessments()
    {
        Gate::authorize('access-social-worker');

        $onHoldAssessments = ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Assessment')
            ->where('current_status', 'On Hold')
            ->latest('on_hold_at')
            ->paginate(10);

        return view('social-worker.on-hold', [
            'onHoldAssessments' => $onHoldAssessments,
        ]);
    }

    public function resumeOnHold(ClientProcessing $clientProcessing)
    {
        Gate::authorize('access-social-worker');

        abort_unless(
            $clientProcessing->current_step === 'Assessment'
            && $clientProcessing->current_status === 'On Hold',
            422
        );

        $clientProcessing->update([
            'current_status' => 'Waiting',
            'is_returnee' => true,
            'resumed_at' => now(),
        ]);

        ActivityLog::record(
            'Assessment Resumed',
            "Resumed on-hold assessment for {$clientProcessing->client->first_name} {$clientProcessing->client->last_name}"
        );

        event(new DashboardUpdated());

        return back()->with('success', 'Client returned to the assessment queue.');
    }

}
