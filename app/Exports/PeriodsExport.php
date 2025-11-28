<?php

namespace App\Exports;

use App\Models\Period;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeriodsExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize, WithStyles
{
    protected $periods;
    protected $customTitle;

    public function __construct($periods, $customTitle = 'Data Periode Gaji Berkala')
    {
        $this->periods = $periods;
        $this->customTitle = $customTitle;
    }

    public function collection()
    {
        return $this->periods;
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Tanggal Awal',
            'Tanggal Akhir',
            'Status',
            'Bulan Tersisa',
            'Dibuat Pada',
            'Diperbarui Pada'
        ];
    }

    public function map($period): array
    {
        $now = \Carbon\Carbon::now();
        $endDate = \Carbon\Carbon::parse($period->tanggal_akhir);
        $daysLeft = $now->diffInDays($endDate, false);
        
        // Calculate months and days properly
        if ($daysLeft >= 0) {
            $monthsLeft = intdiv($daysLeft, 30);
            $remainingDays = $daysLeft % 30;
        } else {
            $monthsLeft = -intdiv(abs($daysLeft), 30);
            $remainingDays = -(abs($daysLeft) % 30);
        }

        // Determine status
        if ($period->status === 'completed') {
            $status = 'Selesai';
        } elseif ($daysLeft < 0) {
            $status = 'Terlambat';
        } elseif ($monthsLeft <= 2) {
            $status = 'Deadline';
        } elseif ($monthsLeft <= 4) {
            $status = 'Segera';
        } else {
            $status = 'Proses';
        }

        // Format time remaining
        if ($daysLeft < 0) {
            if (abs($monthsLeft) > 0) {
                $timeRemaining = 'Telat ' . abs($monthsLeft) . ' bulan ' . (abs($remainingDays) > 0 ? abs($remainingDays) . ' hari' : '');
            } else {
                $timeRemaining = 'Telat ' . abs($remainingDays) . ' hari';
            }
        } elseif ($monthsLeft > 0) {
            $timeRemaining = $monthsLeft . ' bulan ' . ($remainingDays > 0 ? $remainingDays . ' hari' : '') . ' lagi';
        } else {
            $timeRemaining = $remainingDays . ' hari lagi';
        }

        return [
            $period->nama,
            \Carbon\Carbon::parse($period->tanggal_awal)->format('d-m-Y'),
            \Carbon\Carbon::parse($period->tanggal_akhir)->format('d-m-Y'),
            $status,
            $timeRemaining,
            $period->created_at ? \Carbon\Carbon::parse($period->created_at)->format('d-m-Y H:i') : '',
            $period->updated_at ? \Carbon\Carbon::parse($period->updated_at)->format('d-m-Y H:i') : ''
        ];
    }

    public function title(): string
    {
        return $this->customTitle;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style for header row
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => '4F46E5'
                    ]
                ],
                'font' => [
                    'color' => [
                        'rgb' => 'FFFFFF'
                    ]
                ]
            ],
        ];
    }
}
