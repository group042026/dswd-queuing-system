<?php

namespace App\Http\Controllers;

use App\Models\ClientProcessing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApprovingOfficerController extends Controller
{
    public function index()
    {
        Gate::authorize('access-approving-officer');
        return view('approving-officer.dashboard');
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

            $message = 'Application approved. Client moved to Releasing stage.';
        } else {
            // WALANG bagong ClientProcessing dito — mananatili sa "Returned" state
            // hanggang i-resume ni Social Worker mismo
            $message = 'Application returned to Social Worker.';
        }

        return redirect()->route('approving-officer.review')->with('success', $message);
    }
}