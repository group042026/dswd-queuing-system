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
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class QueuePerformanceReportExport extends DefaultValueBinder implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnWidths,
    WithEvents,
    WithCustomValueBinder
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
            in_array($queue->queue_status, ['Completed', 'Cancelled'])
            && $queue->latestProcessing?->end_time
        ) {
            $duration = Carbon::parse($queue->date_issued)
                ->diffForHumans($queue->latestProcessing->end_time, true);
        }

        return [
            $queue->queue_number,
            "{$queue->client->first_name} {$queue->client->last_name}",
            $queue->client->client_category,
            $queue->priority ? 'Yes' : 'No',
            $queue->queue_status,
            $duration,
            $queue->latestProcessing->current_step ?? '—',
            $queue->date_issued ? Carbon::parse($queue->date_issued) : null,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 16, // Queue Number
            'B' => 22, // Client Name
            'C' => 24, // Client Category
            'D' => 12, // Priority
            'E' => 16, // Queue Status
            'F' => 16, // Total Duration
            'G' => 18, // Current Step
            'H' => 20, // Date Issued
        ];
    }

    public function bindValue(Cell $cell, mixed $value): bool
    {
        if ($value instanceof \DateTimeInterface) {
            $cell->setValueExplicit(
                Date::PHPToExcel($value),
                DataType::TYPE_NUMERIC
            );
            return true;
        }

        return parent::bindValue($cell, $value);
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
                "A2:A{$highestRow}", // Queue Number
                "D2:D{$highestRow}", // Priority
                "E2:E{$highestRow}", // Queue Status
                "F2:F{$highestRow}", // Total Duration
                "H2:H{$highestRow}", // Date Issued
            ];

            foreach ($centerColumns as $range) {
                $sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }

        $sheet->getRowDimension(1)->setRowHeight(30);

        for ($row = 2; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        if ($highestRow >= 2) {
            $sheet->getStyle("H2:H{$highestRow}")->getNumberFormat()->setFormatCode('mmmm d, yyyy');
            // $sheet->getStyle("H2:H{$highestRow}")->getNumberFormat()->setFormatCode('mmmm d, yyyy h:mm AM/PM');

        }

        $sheet->setAutoFilter("A1:{$highestColumn}{$highestRow}");
        $sheet->freezePane('A2');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [self::class, 'afterSheet'],
        ];
    }
}