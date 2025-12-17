<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SuratsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $surats;
    protected $title;

    public function __construct($surats, $title = 'Data Surat')
    {
        $this->surats = $surats;
        $this->title = $title;
    }

    public function collection()
    {
        return $this->surats->map(function ($surat, $index) {
            return [
                'No' => $index + 1,
                'Nomor Surat' => $surat->nomor_surat,
                'Judul' => $surat->judul,
                'Pengirim' => $surat->pengirim,
                'Tanggal Surat' => $surat->tanggal_surat->format('d-m-Y'),
                'Status' => $surat->status_label,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Surat',
            'Judul',
            'Pengirim',
            'Tanggal Surat',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'DC2626'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A:F')->getAlignment()->setWrapText(true);

        return [];
    }
}
