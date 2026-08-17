<?php

namespace App\Exports;

use App\Models\Client;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DailyClientReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected string $date;

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function collection(): Enumerable
    {
        return Client::with(['queue' => function ($q) {
                $q->whereDate('date_issued', $this->date);
            }])
            ->whereDate('date_registered', $this->date)
            ->orderBy('date_registered', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Control Number',
            'Queue Number',
            'Full Name',
            'Category',
            'Program Requested',
            'Contact Number',
            'Barangay',
            'Date Registered',
        ];
    }

    public function map($client): array
    {
        return [
            $client->control_number,
            $client->queue->first()->queue_number ?? '—',
            "{$client->first_name} {$client->last_name}",
            $client->client_category,
            $client->program_requested,
            $client->contact_number,
            $client->barangay,
            \Carbon\Carbon::parse($client->date_registered)->format('M d, Y h:i A'),
        ];
    }
}