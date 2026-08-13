<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Assessment;
use App\Models\ClientProcessing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

        $validated = $request->validate([
            'interview_date' => ['required', 'date'],
            'means_verification' => ['required', 'string'],
            'assessment_findings' => ['required', 'string'],
            'recommendation' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);

        $validated['client_id'] = $clientProcessing->client_id;
        $validated['social_worker_id'] = auth()->id();
        $validated['assessment_status'] = 'Completed';

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
        ]);

        ActivityLog::record(
            'Assessment Completed',
            "Completed assessment for client — Recommendation: {$validated['recommendation']}"
        );

        return redirect()->route('social-worker.assessment')->with('success', 'Assessment completed. Client moved to Review stage.');
    }

    public function returnedAssessments()
    {
        Gate::authorize('access-social-worker');

        $returned = ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Review')
            ->where('current_status', 'Completed')
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
            ->paginate(10);

        return view('social-worker.returned', ['returned' => $returned]);
    }

    public function resumeAssessment(ClientProcessing $clientProcessing)
    {
        Gate::authorize('access-social-worker');

        $assessment = $clientProcessing->client->assessment;
        $assessment->update(['approval_status' => 'Resumed']);

        ClientProcessing::create([
            'client_id' => $clientProcessing->client_id,
            'user_id' => auth()->id(),
            'queue_id' => $clientProcessing->queue_id,
            'current_step' => 'Assessment',
            'current_status' => 'Waiting',
            'start_time' => now(),
        ]);

        ActivityLog::record(
            'Assessment Resumed',
            "Resumed assessment for {$clientProcessing->client->first_name} {$clientProcessing->client->last_name} — moved back to Pending Assessment"
        );


        return redirect()->route('social-worker.returned')->with('success', 'Client moved back to Pending Assessment.');
    }
}
