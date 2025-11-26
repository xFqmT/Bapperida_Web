<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Period extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
    ];

    protected $dates = [
        'tanggal_awal',
        'tanggal_akhir',
    ];

    // Mutator: hitung tanggal akhir otomatis saat diset
    public function setTanggalAwalAttribute($value)
    {
        $this->attributes['tanggal_awal'] = $value;
        if (!$this->tanggal_akhir || $this->isDirty('tanggal_awal')) {
            $this->attributes['tanggal_akhir'] = Carbon::parse($value)->addYears(2);
        }
    }

    // Accessor untuk status berdasarkan bulan tersisa
    public function getStatusPeriodAttribute()
    {
        if ($this->status === 'completed') {
            return 'selesai';
        }

        $now = Carbon::now();
        $endDate = Carbon::parse($this->tanggal_akhir);
        $monthsLeft = $now->diffInMonths($endDate, false);

        if ($monthsLeft < 0) {
            return 'selesai'; // Lewat tanggal
        } elseif ($monthsLeft <= 2) {
            return 'deadline';
        } elseif ($monthsLeft <= 4) {
            return 'segera';
        } else {
            return 'proses';
        }
    }

    // Accessor untuk warna status
    public function getStatusColorAttribute()
    {
        $status = $this->status_period;
        
        switch ($status) {
            case 'deadline':
                return 'red';
            case 'segera':
                return 'yellow';
            case 'proses':
                return 'green';
            case 'selesai':
                return 'gray';
            default:
                return 'default';
        }
    }

    // Accessor untuk bulan tersisa
    public function getMonthsLeftAttribute()
    {
        $now = Carbon::now();
        $endDate = Carbon::parse($this->tanggal_akhir);
        return $now->diffInMonths($endDate, false);
    }

    // Cek apakah masih aktif
    public function isActive()
    {
        return $this->status === 'active' && $this->monthsLeft >= 0;
    }
}