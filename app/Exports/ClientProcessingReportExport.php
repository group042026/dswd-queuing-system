<?php

namespace App\Exports;

use App\Models\ClientProcessing;
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

class ClientProcessingReportExport extends DefaultValueBinder implements
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
            "{$processing->client->first_name} {$processing->client->last_name}",
            $processing->current_step,
            $processing->current_status,
            $processing->user
                ? "{$processing->user->first_name} {$processing->user->last_name}"
                : '—',
            $processing->start_time ? Carbon::parse($processing->start_time) : null,
            $processing->end_time ? Carbon::parse($processing->end_time) : null,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 16, // Queue Number
            'B' => 22, // Client Name
            'C' => 16, // Step
            'D' => 16, // Status
            'E' => 22, // Handled By
            'F' => 26, // Start Time
            'G' => 26, // End Time
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
                "C2:C{$highestRow}", // Step
                "D2:D{$highestRow}", // Status
                "F2:F{$highestRow}", // Start Time
                "G2:G{$highestRow}", // End Time
            ];

            foreach ($centerColumns as $range) {
                $sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }

        $sheet->getRowDimension(1)->setRowHeight(30);

        for ($row = 2; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(16);
        }

        if ($highestRow >= 2) {
            $sheet->getStyle("F2:F{$highestRow}")->getNumberFormat()->setFormatCode('mmmm d, yyyy h:mm AM/PM');
            $sheet->getStyle("G2:G{$highestRow}")->getNumberFormat()->setFormatCode('mmmm d, yyyy h:mm AM/PM');
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