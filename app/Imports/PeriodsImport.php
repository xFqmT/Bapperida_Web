<?php

namespace App\Imports;

use App\Models\Period;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PeriodsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['nama']) || !isset($row['tanggal_awal'])) {
            return null;
        }

        $nama = trim((string) $row['nama']);
        $rawDate = $row['tanggal_awal'];

        if ($nama === '' || $rawDate === null || $rawDate === '') {
            return null;
        }

        $date = $this->parseDate($rawDate);

        return new Period([
            'nama' => $nama,
            'tanggal_awal' => $date->format('Y-m-d'),
        ]);
    }

    private function parseDate($value): \Carbon\Carbon
    {
        if (is_numeric($value)) {
            $dt = Date::excelToDateTimeObject($value);
            return \Carbon\Carbon::instance($dt);
        }

        $str = str_replace('/', '-', trim((string) $value));
        $formats = ['Y-m-d', 'd-m-Y', 'm-d-Y', 'd-M-Y', 'd-m-y', 'Y-n-j', 'd-n-Y'];

        foreach ($formats as $fmt) {
            try {
                $dt = \Carbon\Carbon::createFromFormat($fmt, $str);
                if ($dt !== false) {
                    return $dt;
                }
            } catch (\Throwable $e) {
                // try next format
            }
        }

        return \Carbon\Carbon::parse($str);
    }
}