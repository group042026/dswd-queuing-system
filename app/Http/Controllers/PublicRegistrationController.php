<?php

namespace App\Http\Controllers;

use App\Events\DashboardUpdated;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\Documents;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicRegistrationController extends Controller
{
    public function create()
    {
        return view('public.self-register');
    }

    public function store(Request $request)
    {
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
            'mode_of_release' => ['required', 'in:Outright Cash'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'program_requested' => ['required', 'string'],
            'type_of_assistance' => ['required', 'in:CASH RELIEF ASSISTANCE,MEDICAL ASSISTANCE,FUNERAL ASSISTANCE'],
            'id_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'other_documents' => ['nullable', 'array'],
            'other_documents.*' => ['image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        $validated['subcategory'] = implode(', ', $validated['subcategory']);
        $validated['mode_of_admission'] = 'Offsite';
        $validated['service_modality'] = 'Offsite';
        $validated['control_number'] = $this->generateControlNumber();
        $validated['date_registered'] = now();

        $idPhoto = $request->file('id_photo');
        $otherDocuments = $request->file('other_documents') ?? [];

        DB::transaction(function () use ($validated, $idPhoto, $otherDocuments, &$queueNumber, &$controlNumber) {
            $client = Client::create($validated);

            $isPriority = in_array($client->client_category, [
                'Senior Citizens',
                'Men/Women in specially difficult circumstances',
            ]);

            $queue = Queue::create([
                'queue_number' => $this->generateQueueNumber($isPriority),
                'client_id' => $client->id,
                'priority' => $isPriority,
                'queue_status' => 'Pending Arrival',
                'date_issued' => now(),
            ]);

            // I-save ang ID photo
            $idPath = $idPhoto->store('client-documents', 'public');
            Documents::create([
                'client_id' => $client->id,
                'document_name' => $client->valid_id_type,
                'file_path' => $idPath,
                'verified' => false,
            ]);

            // I-save ang ibang documents (kung meron)
            foreach ($otherDocuments as $doc) {
                $docPath = $doc->store('client-documents', 'public');
                Documents::create([
                    'client_id' => $client->id,
                    'document_name' => 'Supporting Document',
                    'file_path' => $docPath,
                    'verified' => false,
                ]);
            }

            ActivityLog::record(
                'Online Pre-Registration',
                "Client {$client->first_name} {$client->last_name} pre-registered online (Control #: {$client->control_number}, Queue #: {$queue->queue_number})"
            );

            event(new DashboardUpdated());

            $queueNumber = $queue->queue_number;
            $controlNumber = $client->control_number;
        });

        return redirect()->route('public.register.success')->with([
            'queue_number' => $queueNumber,
            'control_number' => $controlNumber,
        ]);
    }

    public function success()
    {
        if (! session('queue_number')) {
            return redirect()->route('public.register');
        }

        return view('public.register-success', [
            'queueNumber' => session('queue_number'),
            'controlNumber' => session('control_number'),
        ]);
    }

    public function trackForm()
    {
        return view('public.track-application');
    }

    public function track(Request $request)
    {
        $validated = $request->validate([
            'control_number' => ['required', 'string', 'max:50'],
            'contact_number' => ['required', 'string', 'max:15'],
        ]);

        $queue = Queue::with([
            'client',
            'latestProcessing',
        ])
            ->whereHas('client', function ($query) use ($validated) {
                $query
                    ->where('control_number', $validated['control_number'])
                    ->where('contact_number', $validated['contact_number']);
            })
            ->latest('date_issued')
            ->first();

        if (! $queue) {
            return back()
                ->withInput()
                ->withErrors([
                    'tracking' => 'No matching application was found.',
                ]);
        }

        $processing = $queue->latestProcessing;

        $statusLabel = match (true) {
            $queue->queue_status === 'Cancelled' => 'Application Cancelled',
            $queue->queue_status === 'Completed' => 'Application Completed',
            $queue->queue_status === 'Pending Arrival' => 'Waiting for Arrival',
            $processing?->current_step === 'Validation' => 'For Document Validation',
            $processing?->current_step === 'Assessment' => 'For Assessment',
            $processing?->current_step === 'Review' => 'For Review',
            $processing?->current_step === 'Releasing' => 'For Releasing',
            default => $queue->queue_status,
        };

        return view('public.track-application', [
            'application' => $queue,
            'statusLabel' => $statusLabel,
        ]);
    }

    private function generateControlNumber(): string
    {
        $year = now()->format('Y');
        $count = Client::whereYear('date_registered', $year)->count() + 1;

        return "CN-{$year}-" . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    private function generateQueueNumber(bool $isPriority): string
    {
        $today = now()->toDateString();

        $count = Queue::whereDate('date_issued', $today)
            ->where('priority', $isPriority)
            ->count() + 1;

        return str_pad($count, 2, '0', STR_PAD_LEFT);
    }

}