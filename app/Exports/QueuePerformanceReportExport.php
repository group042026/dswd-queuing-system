<?php

namespace App\Exports;

use App\Models\Queue;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class QueuePerformanceReportExport implements FromCollection, WithHeadings, WithMapping
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
        return Queue::with(['client', 'latestProcessing'])
            ->whereDate('date_issued', '>=', $this->dateFrom)
            ->whereDate('date_issued', '<=', $this->dateTo)
            ->orderBy('date_issued', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Queue Number',
            'Client Name',
            'Priority',
            'Queue Status',
            'Current Step',
            'Total Duration',
            'Date Issued',
        ];
    }

    public function map($queue): array
    {
        $duration = 'In Progress';

        if (in_array($queue->queue_status, ['Completed', 'Cancelled']) && $queue->latestProcessing?->end_time) {
            $duration = \Carbon\Carbon::parse($queue->date_issued)
                ->diffForHumans($queue->latestProcessing->end_time, true);
        }

        return [
            $queue->queue_number,
            "{$queue->client->first_name} {$queue->client->last_name}",
            $queue->priority ? 'Yes' : 'No',
            $queue->queue_status,
            $queue->latestProcessing->current_step ?? '—',
            $duration,
            \Carbon\Carbon::parse($queue->date_issued)->format('M d, Y h:i A'),
        ];
    }
}