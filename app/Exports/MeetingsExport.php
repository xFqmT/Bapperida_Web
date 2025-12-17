<?php

namespace App\Exports;

use App\Models\Meeting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MeetingsExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize, WithStyles
{
    protected $meetings;
    protected $customTitle;

    public function __construct($meetings, $customTitle = 'Data Jadwal Rapat')
    {
        $this->meetings = $meetings;
        $this->customTitle = $customTitle;
    }

    public function collection()
    {
        return $this->meetings;
    }

    public function headings(): array
    {
        return [
            'PIC',
            'Agenda',
            'Tanggal',
            'Hari',
            'Waktu Mulai',
            'Waktu Selesai',
            'Ruang Rapat',
            'Status',
            'Catatan',
            'Dibuat Pada',
            'Diperbarui Pada'
        ];
    }

    public function map($meeting): array
    {
        // Determine status in Indonesian
        $status = match($meeting->status) {
            'scheduled' => 'Terjadwal',
            'ongoing' => 'Berlangsung',
            'done' => 'Selesai',
            default => $meeting->status
        };

        // Format day name
        $dayNames = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin', 
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        
        $dayName = $dayNames[\Carbon\Carbon::parse($meeting->date)->format('l')] ?? $meeting->date;

        return [
            $meeting->pic,
            $meeting->agenda,
            \Carbon\Carbon::parse($meeting->date)->format('d-m-Y'),
            $dayName,
            $meeting->start_time,
            $meeting->end_time ?? '-',
            $meeting->ruang_rapat ?? '-',
            $status,
            $meeting->notes ?? '-',
            $meeting->created_at ? \Carbon\Carbon::parse($meeting->created_at)->format('d-m-Y H:i') : '',
            $meeting->updated_at ? \Carbon\Carbon::parse($meeting->updated_at)->format('d-m-Y H:i') : ''
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
                        'rgb' => '059669'
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
