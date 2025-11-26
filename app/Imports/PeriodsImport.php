<?php

namespace App\Imports;

use App\Models\Period;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PeriodsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Period([
            'nama' => $row['nama'],
            'tanggal_awal' => \Carbon\Carbon::parse($row['tanggal_awal'])->format('Y-m-d'),
            // tanggal_akhir akan otomatis dihitung via mutator
        ]);
    }
}