<?php

namespace App\Exports;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DailyClientReportExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnWidths,
    WithEvents
{
    protected string $date;
    protected string $enteredBy;

    public function __construct(string $date)
    {
        $this->date = $date;

        $this->enteredBy =
            auth()->user()->first_name . ' ' .
            auth()->user()->last_name;
    }

    public function collection(): Enumerable
    {
        return Client::whereDate('date_registered', $this->date)
            ->orderBy('date_registered', 'asc')
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
            'Service Modality',
        ];
    }

    public function map($client): array
    {
        return [
            $this->enteredBy,

            $client->control_number,

            $client->date_registered
                ? Carbon::parse($client->date_registered)
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

            // Assistance
            $client->type_of_assistance,
            $client->amount,
            $client->program_requested,
            $client->mode_of_release,

            $client->client_category,
            $client->subcategory,
            strtoupper($client->occupation),
            $client->salary,
            $client->household_size,

            '', // Service Modality
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | COLUMN WIDTHS
    |--------------------------------------------------------------------------
    | NOTE: map()/headings() only output 27 columns, A through AA.
    | Widths below now match that exactly (previously this pointed at
    | AH-AM, which don't correspond to any real column — that's what
    | was causing PhpSpreadsheet to think the sheet extended all the
    | way to AM and draw filter dropdowns on the empty columns in between).
    |--------------------------------------------------------------------------
    */

    public function columnWidths(): array
    {
        return [

            // Personal / Location
            'A' => 18, // Entered By
            'B' => 12, // Client No.
            'C' => 18, // Date of Assistance
            'D' => 28, // Region
            'E' => 22, // Province
            'F' => 24, // City/Municipality
            'G' => 22, // Barangay
            'H' => 12, // District

            // Name
            'I' => 18, // Last Name
            'J' => 18, // First Name
            'K' => 18, // Middle Name
            'L' => 14, // Extra Name

            // Personal details
            'M' => 10, // Sex
            'N' => 15, // Civil Status
            'O' => 18, // DOB
            'P' => 8,  // Age

            // Admission
            'Q' => 20, // Mode of Admission

            // Assistance
            'R' => 24, // Type of Assistance
            'S' => 14, // Amount
            'T' => 22, // Source of Fund
            'U' => 20, // Mode of Release

            // Other information
            'V' => 20, // Client Category
            'W' => 20, // Subcategory
            'X' => 24, // Occupation
            'Y' => 14, // Salary
            'Z' => 20, // Number of Family Members
            'AA' => 20, // Service Modality
        ];
    }

    public static function afterSheet(AfterSheet $event): void
    {
        $sheet = $event->sheet->getDelegate();

        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // HEADER
        $headerRange = "A1:{$highestColumn}1";

        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'name' => 'Calibri',
                'size' => 10,
                'bold' => true,
                'color' => [
                    'rgb' => '000000',
                ],
            ],

            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFFFFF',
                ],
            ],

            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],

            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'rgb' => 'D9D9D9',
                    ],
                ],
            ],
        ]);

        //BODY

        if ($highestRow >= 2) {

            $bodyRange = "A2:{$highestColumn}{$highestRow}";

            $sheet->getStyle($bodyRange)->applyFromArray([
                'font' => [
                    'name' => 'Calibri',
                    'size' => 10,
                    'color' => [
                        'rgb' => '000000',
                    ],
                ],

                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],

                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => 'E6E6E6',
                        ],
                    ],
                ],
            ]);

            $centerColumns = [
                "A2:A{$highestRow}", // Entered By
                "B2:B{$highestRow}", // Client No.
                "C2:C{$highestRow}", // Date of Assistance
                "M2:M{$highestRow}", // Sex
                "N2:N{$highestRow}", // Civil Status
                "Q2:Q{$highestRow}", // Mode of Admission
                "T2:T{$highestRow}", // Source of Fund
            ];

            foreach ($centerColumns as $range) {
                $sheet->getStyle($range)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }

        //ROW HEIGHT

        // Header
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Data rows
        for ($row = 2; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        //DATE FORMATTING

        if ($highestRow >= 2) {

            // Date of Assistance
            $sheet->getStyle("C2:C{$highestRow}")
                ->getNumberFormat()
                ->setFormatCode('mmmm d, yyyy');

            // DOB
            $sheet->getStyle("O2:O{$highestRow}")
                ->getNumberFormat()
                ->setFormatCode('mmmm d, yyyy');
        }

        //NUMBER FORMATTING

        if ($highestRow >= 2) {
            // Amount
            $sheet->getStyle("S2:S{$highestRow}")
                ->getNumberFormat()
                ->setFormatCode('#,##0.00');
        }

        //AUTOFILTER

        $sheet->setAutoFilter(
            "A1:{$highestColumn}{$highestRow}"
        );

        //FREEZE HEADER

        $sheet->freezePane('A2');
    }

    //EVENTS
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