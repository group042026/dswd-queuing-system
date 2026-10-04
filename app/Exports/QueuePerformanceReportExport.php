<?php

namespace App\Exports;

use App\Models\Queue;
use Carbon\Carbon;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\DefaultValueBinder;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class QueuePerformanceReportExport extends DefaultValueBinder implements FromCollection, WithColumnWidths, WithCustomValueBinder, WithEvents, WithHeadings, WithMapping
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
            'Client Category',
            'Priority',
            'Queue Status',
            'Total Duration',
            'Current Step',
            'Date Issued',
        ];
    }

    public function map($queue): array
    {
        $duration = 'In Progress';

        if ($queue->queue_status === 'Abandoned') {
            $duration = 'Abandoned';
        } elseif (
            in_array($queue->queue_status, ['Completed', 'Cancelled'], true)
            && $queue->latestProcessing?->end_time
            && $queue->date_issued
        ) {
            $duration = Carbon::parse($queue->date_issued)
                ->diffForHumans(
                    Carbon::parse($queue->latestProcessing->end_time),
                    true
                );
        }

        $clientName = trim(implode(' ', array_filter([
            $queue->client?->first_name,
            $queue->client?->last_name,
        ])));

        return [
            $queue->queue_number ?? '—',
            $clientName !== '' ? $clientName : '—',
            $queue->client?->client_category ?? '—',
            $queue->priority ? 'Yes' : 'No',
            $queue->queue_status ?? '—',
            $duration,
            $queue->latestProcessing?->current_step ?? '—',

            // Gawing string muna, gaya ng stable export setup.
            $queue->date_issued
                ? Carbon::parse($queue->date_issued)->format('Y-m-d')
                : '—',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 16,
            'B' => 22,
            'C' => 24,
            'D' => 12,
            'E' => 16,
            'F' => 16,
            'G' => 18,
            'H' => 20,
        ];
    }

    public static function afterSheet(AfterSheet $event): void
    {
        $sheet = $event->sheet->getDelegate();

        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $headerRange = "A1:{$highestColumn}1";

        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'name' => 'Calibri',
                'size' => 10,
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D9D9D9'],
                ],
            ],
        ]);

        if ($highestRow >= 2) {
            $bodyRange = "A2:{$highestColumn}{$highestRow}";

            $sheet->getStyle($bodyRange)->applyFromArray([
                'font' => [
                    'name' => 'Calibri',
                    'size' => 10,
                    'color' => ['rgb' => '000000'],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E6E6E6'],
                    ],
                ],
            ]);

            $centerColumns = [
                "A2:A{$highestRow}",
                "D2:D{$highestRow}",
                "E2:E{$highestRow}",
                "F2:F{$highestRow}",
                "H2:H{$highestRow}",
            ];

            foreach ($centerColumns as $range) {
                $sheet->getStyle($range)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }

        $sheet->getRowDimension(1)->setRowHeight(30);

        for ($row = 2; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        $sheet->setAutoFilter("A1:{$highestColumn}{$highestRow}");
        $sheet->freezePane('A2');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [
                self::class,
                'afterSheet',
            ],
        ];
    }
}
