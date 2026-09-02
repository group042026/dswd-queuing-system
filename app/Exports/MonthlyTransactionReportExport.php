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
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\DefaultValueBinder;

class MonthlyTransactionReportExport extends DefaultValueBinder implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnWidths,
    WithEvents,
    WithCustomValueBinder
{
    protected string $month;
    protected string $enteredBy;

    public function __construct(string $month)
    {
        $this->month = $month;
        $this->enteredBy = auth()->user()->first_name . ' ' . auth()->user()->last_name;
    }

    public function collection(): Enumerable
    {
        [$year, $month] = explode('-', $this->month);

        return ClientProcessing::with('client')
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
            'Entered By',
            'Client No.',
            'Date of Assistance',
            'Region',
            'Province',
            'City/Municipality',
            'Barangay',
            'District',
            'Last Name',
            'First Name',
            'Middle Name',
            'Extra Name',
            'Sex',
            'Civil Status',
            'DOB',
            'Age',
            'Mode of Admission',
            'Type of Assistance',
            'Amount',
            'Source of Fund',
            'Mode of Release',
            'Client Category',
            'Subcategory',
            'Occupation',
            'Salary',
            'Number of Family Members',
        ];
    }

    public function map($processing): array
    {
        $client = $processing->client;

        return [
            $this->enteredBy,

            $client->control_number,

            $processing->end_time
                ? Carbon::parse($processing->end_time)
                : null,

            $client->region ? strtoupper($client->region) : null,
            $client->province ? strtoupper($client->province) : null,
            $client->municipality ? strtoupper($client->municipality) : null,
            $client->barangay ? strtoupper($client->barangay) : null,
            $client->district ? strtoupper($client->district) : null,

            $client->last_name ? strtoupper($client->last_name) : null,
            $client->first_name ? strtoupper($client->first_name) : null,
            $client->middle_name ? strtoupper($client->middle_name) : null,
            $client->suffix ? strtoupper($client->suffix) : null,

            $client->sex ? strtoupper($client->sex) : null,
            $client->civil_status ? strtoupper($client->civil_status) : null,

            $client->birthdate
                ? Carbon::parse($client->birthdate)
                : null,

            $client->age,

            $client->mode_of_admission,

            $client->type_of_assistance,
            $client->amount,
            $client->program_requested,
            $client->mode_of_release,

            $client->client_category,
            $client->subcategory,
            $client->occupation ? strtoupper($client->occupation) : null,
            $client->salary,
            $client->household_size,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18, // Entered By
            'B' => 12, // Client No.
            'C' => 18, // Date of Assistance
            'D' => 28, // Region
            'E' => 22, // Province
            'F' => 24, // City/Municipality
            'G' => 22, // Barangay
            'H' => 12, // District
            'I' => 18, // Last Name
            'J' => 18, // First Name
            'K' => 18, // Middle Name
            'L' => 14, // Extra Name
            'M' => 10, // Sex
            'N' => 15, // Civil Status
            'O' => 18, // DOB
            'P' => 8,  // Age
            'Q' => 20, // Mode of Admission
            'R' => 24, // Type of Assistance
            'S' => 14, // Amount
            'T' => 22, // Source of Fund
            'U' => 20, // Mode of Release
            'V' => 20, // Client Category
            'W' => 20, // Subcategory
            'X' => 24, // Occupation
            'Y' => 14, // Salary
            'Z' => 20, // Number of Family Members
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
                "B2:B{$highestRow}",
                "C2:C{$highestRow}",
                "M2:M{$highestRow}",
                "N2:N{$highestRow}",
                "Q2:Q{$highestRow}",
                "T2:T{$highestRow}",
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
            $sheet->getStyle("C2:C{$highestRow}")->getNumberFormat()->setFormatCode('mmmm d, yyyy');
            $sheet->getStyle("O2:O{$highestRow}")->getNumberFormat()->setFormatCode('mmmm d, yyyy');
            $sheet->getStyle("S2:S{$highestRow}")->getNumberFormat()->setFormatCode('#,##0.00');
        }

        $sheet->setAutoFilter("A1:{$highestColumn}{$highestRow}");
        $sheet->freezePane('A2');
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


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [self::class, 'afterSheet'],
        ];
    }
}