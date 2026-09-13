<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Models\ActivityLog;
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

        $idFormats = [
            'Philippine National ID' => '/^\d{12}$/',
            'SSS ID' => '/^\d{2}-\d{7}-\d{1}$/',
            'PhilHealth ID' => '/^\d{2}-\d{9}-\d{1}$/',
            "Driver's License" => '/^[A-Za-z]\d{2}-\d{2}-\d{6}$/',
            'Passport' => '/^[A-Za-z]\d{8}$/',
        ];

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'sex' => ['required', 'in:Male,Female'],
            'birthdate' => ['required', 'date', 'before:today', 'after:' . now()->subYears(130)->format('Y-m-d')],
            'age' => ['required', 'integer', 'min:0', 'max:130'],
            'civil_status' => ['required', 'string'],
            'barangay' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'municipality' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'region' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'min:7', 'max:15', 'regex:/^\+?[0-9\s\-]+$/'],
            'valid_id_type' => ['required', 'string'],
            'valid_id_number' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($request, $idFormats) {
                    $idType = $request->input('valid_id_type');

                    if (isset($idFormats[$idType]) && !preg_match($idFormats[$idType], $value)) {
                        $fail("The ID number format is invalid for {$idType}.");
                    }
                },
            ],
            'client_category' => ['required', 'in:Senior Citizens,Family heads and Other Needy Adult,Youth in Need and Other Needy Adult,Youth in Need of Special Protection,Men/Women in specially difficult circumstances'],
            'subcategory' => ['required', 'array', 'min:1'],
            'subcategory.*' => ['in:NONE OF THE ABOVE,BELOW MINIMUM WAGE EARNER,NO REGULAR INCOME,INDIGENOUS PEOPLE,SOLO PARENT,4PS BENEFICIARY'],
            'mode_of_admission' => ['required', 'in:Walk-in,Offsite'],
            'service_modality' => ['required', 'in:Walk-in,Offsite'],
            'mode_of_release' => ['required', 'in:Outright Cash'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'program_requested' => ['required', 'string'],
            'type_of_assistance' => ['required', 'in:CASH RELIEF ASSISTANCE,MEDICAL ASSISTANCE,FUNERAL ASSISTANCE'],
        ]);

        $validated['subcategory'] = implode(', ', $validated['subcategory']);

        $validated['control_number'] = $this->generateControlNumber();
        $validated['date_registered'] = now();

        DB::transaction(function () use ($validated) {
            $client = Client::create($validated);

            $isPriority = in_array($client->client_category, [
                'Senior Citizens',
                'Men/Women in specially difficult circumstances',
            ]);

            $queue = Queue::create([
                'queue_number' => $this->generateQueueNumber($isPriority),
                'client_id' => $client->id,
                'priority' => $isPriority,
                'queue_status' => 'Serving',
                'date_issued' => now(),
            ]);

            ClientProcessing::create([
                'client_id' => $client->id,
                'user_id' => auth()->id(),
                'queue_id' => $queue->id,
                'current_step' => 'Validation',
                'current_status' => 'Processing',
                'start_time' => now(),
            ]);

            ActivityLog::record(
                'Client Registered',
                "Registered client {$client->first_name} {$client->last_name} (Control #: {$client->control_number}, Queue #: {$queue->queue_number})"
            );

            event(new DashboardUpdated());
        });

        return redirect()->route('receptionist.dashboard')->with('success', 'Client registered and added to queue successfully.');
    }

    private function generateControlNumber(): string
    {
        $year  = now()->format('Y');
        $count = Client::whereYear('date_registered', $year)->count() + 1;

        return "CN-{$year}-" . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    private function generateQueueNumber(bool $isPriority): string
    {
        $today = now()->toDateString();

        $count = Queue::whereDate('date_issued', $today)
            ->where('priority', $isPriority)
            ->count() + 1;

        return str_pad($count, 2, '0', STR_PAD_LEFT); // 01, 02, ..., 99, 100, 101...
    }
}
