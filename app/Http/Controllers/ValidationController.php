<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\ClientProcessing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ValidationController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('access-receptionist');

        $selectedDate = $request->input('date', now()->format('Y-m-d'));

        $pendingValidation = ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Validation')
            ->where('current_status', 'Processing')
            ->whereDate('start_time', $selectedDate)
            ->orderBy('start_time', 'asc')
            ->paginate(10)
            ->appends(['date' => $selectedDate]);

        return view('receptionist.validation', ['pendingValidation' => $pendingValidation, 'selectedDate' => $selectedDate]);
    }

    public function proceed(ClientProcessing $clientProcessing)
    {
         Gate::authorize('access-receptionist');

        $client = $clientProcessing->client;

        if ($client->documents->isEmpty()) {
            return back()->withErrors(['documents' => 'Upload requirements first']);
        }

        if ($client->documents->contains('verified', false)) {
            return back()->withErrors(['documents' => 'Not all documents are verified']);
        }
        
        $clientProcessing->update([
            'current_status' => 'Completed',
            'end_time' => now(),
        ]);

        ClientProcessing::create([
            'client_id' => $clientProcessing->client_id,
            'user_id' => auth()->id(),
            'queue_id' => $clientProcessing->queue_id,
            'current_step' => 'Assessment',
            'current_status' => 'Waiting',
            'start_time' => now(),
        ]);

        ActivityLog::record(
            'Client Validated',
            "Validated client {$client->first_name} {$client->last_name} — moved to Assessment stage"
        );

        return redirect()->route('receptionist.validation')->with('success', 'Client moved to Assessment stage.');
    }
}