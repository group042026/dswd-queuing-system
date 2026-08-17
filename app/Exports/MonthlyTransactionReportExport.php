<?php

namespace App\Exports;

use App\Models\ClientProcessing;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MonthlyTransactionReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected string $month; // format: Y-m, e.g. 2026-08

    public function __construct(string $month)
    {
        $this->month = $month;
    }

    public function collection(): Enumerable
    {
        [$year, $month] = explode('-', $this->month);

        return ClientProcessing::with(['client', 'queue'])
            ->where('current_step', 'Releasing')
            ->where('current_status', 'Completed')
            ->whereYear('end_time', $year)
            ->whereMonth('end_time', $month)
            ->orderBy('end_time', 'asc')
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
            'Date Released',
        ];
    }

    public function map($processing): array
    {
        return [
            $processing->client->control_number,
            $processing->queue->queue_number ?? '—',
            "{$processing->client->first_name} {$processing->client->last_name}",
            $processing->client->client_category,
            $processing->client->program_requested,
            \Carbon\Carbon::parse($processing->end_time)->format('M d, Y h:i A'),
        ];
    }
}