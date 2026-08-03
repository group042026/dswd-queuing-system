<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientProcessing;
use App\Models\Queue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function create()
    {
        Gate::authorize('access-receptionist');

        return view('receptionist.clientRegistration');
    }

    public function store(Request $request)
    {
        Gate::authorize('access-receptionist');

        $validated = $request->validate([
            'first_name'            => ['required', 'string', 'max:255'],
            'middle_name'           => ['nullable', 'string', 'max:255'],
            'last_name'             => ['required', 'string', 'max:255'],
            'suffix'                => ['nullable', 'string', 'max:10'],
            'sex'                   => ['required', 'in:Male,Female'],
            'birthdate'             => ['required', 'date', 'before:today'],
            'age'                   => ['required', 'integer', 'min:0'],
            'civil_status'          => ['required', 'string'],
            'barangay'              => ['required', 'string', 'max:255'],
            'municipality'          => ['required', 'string', 'max:255'],
            'province'              => ['required', 'string', 'max:255'],
            'email'                 => ['nullable', 'email', 'max:255'],
            'occupation'            => ['nullable', 'string', 'max:255'],
            'contact_number'        => ['required', 'string', 'min:7', 'max:15', 'regex:/^\+?[0-9\s\-]+$/'],
            'monthly_income'        => ['required', 'numeric', 'min:0'],
            'household_size'        => ['required', 'integer', 'min:1'],
            'valid_id_type'         => ['required', 'string'],
            'valid_id_number'       => ['required', 'string', 'max:255'],
            'client_category'       => ['required', 'in:Senior,PWD,Solo Parent,Regular'],
            'program_requested'     => ['required', 'string'],
            'reason_for_assistance' => ['required', 'string'],
        ]);

        $validated['control_number'] = $this->generateControlNumber();
        $validated['date_registered'] = now();

        DB::transaction(function () use ($validated) {
            $client = Client::create($validated);

            $queue = Queue::create([
                'queue_number'  => $this->generateQueueNumber(),
                'client_id'     => $client->id,
                'priority'      => in_array($client->client_category, ['Senior', 'PWD', 'Solo Parent']),
                'queue_status'  => 'Waiting',
                'date_issued'   => now(),
            ]);

            ClientProcessing::create([
                'client_id'      => $client->id,
                'user_id'        => auth()->id(),
                'queue_id'       => $queue->id,
                'current_step'   => 'Validation',
                'current_status' => 'Waiting',
                'start_time'     => now(),
            ]);
        });

        return redirect()->route('receptionist.dashboard')->with('success', 'Client registered and added to queue successfully.');
    }

    private function generateControlNumber(): string
    {
        $year  = now()->format('Y');
        $count = Client::whereYear('date_registered', $year)->count() + 1;

        return "CN-{$year}-" . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    private function generateQueueNumber(): string
    {
        $today = now()->format('Ymd');
        $count = Queue::whereDate('date_issued', now())->count() + 1;

        return "{$today}-" . str_pad($count, 3, '0', STR_PAD_LEFT); // hal. 20260802-001, mag-rereset sa 001 kada bagong araw
    }
}
