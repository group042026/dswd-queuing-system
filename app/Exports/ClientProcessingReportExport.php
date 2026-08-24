<?php

namespace App\Exports;

use App\Models\ClientProcessing;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientProcessingReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected string $dateFrom;
    protected string $dateTo;

    public function __construct(string $dateFrom, string $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function collection(): Enumerable
    {
        return ClientProcessing::with(['client', 'queue', 'user'])
            ->whereDate('start_time', '>=', $this->dateFrom)
            ->whereDate('start_time', '<=', $this->dateTo)
            ->orderBy('start_time', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Queue Number',
            'Client Name',
            'Step',
            'Status',
            'Handled By',
            'Start Time',
            'End Time',
        ];
    }

    public function map($processing): array
    {
        return [
            $processing->queue->queue_number ?? '—',
            $processing->user ? "{$processing->user->first_name} {$processing->user->last_name}" : '—',
            $processing->current_step,
            $processing->current_status,
            $processing->user->name ?? '—',
            \Carbon\Carbon::parse($processing->start_time)->format('M d, Y h:i A'),
            $processing->end_time ? \Carbon\Carbon::parse($processing->end_time)->format('M d, Y h:i A') : '—',
        ];
    }
}