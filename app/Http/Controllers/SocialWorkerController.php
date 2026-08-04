<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\ClientProcessing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SocialWorkerController extends Controller
{
    public function index()
    {
        Gate::authorize('access-social-worker');

        return view('social-worker.dashboard');
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

        $assessment = Assessment::create($validated);

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

        return redirect()->route('social-worker.assessment')->with('success', 'Assessment completed. Client moved to Review stage.');
    }
}