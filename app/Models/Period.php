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

    // Accessor untuk status berdasarkan selisih waktu
    public function getStatusPeriodAttribute()
    {
        if ($this->status === 'completed') {
            return 'selesai';
        }

        $now = Carbon::now();
        $startDate = Carbon::parse($this->tanggal_awal);
        $endDate = Carbon::parse($this->tanggal_akhir);
        
        // Hitung selisih menggunakan DateInterval untuk akurasi bulan & hari
        $interval = $now->diff($endDate);
        $isPast = (bool) $interval->invert; // true jika sudah lewat
        $months = (int) ($interval->y * 12 + $interval->m);
        $days = (int) $interval->d;

        // Terlambat: tanggal akhir telah lewat
        if ($isPast) {
            return 'terlambat';
        }

        // Deadline: kurang dari 2 bulan
        if ($months < 2) {
            return 'deadline';
        }

        // Segera: kurang dari 4 bulan, atau tepat 4 bulan 0 hari
        if ($months < 4 || ($months === 4 && $days === 0)) {
            return 'segera';
        }

        // Proses: lebih dari 4 bulan
        return 'proses';
    }

    // Accessor untuk warna status
    public function getStatusColorAttribute()
    {
        $status = $this->status_period;
        
        switch ($status) {
            case 'terlambat':
                return 'purple';
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

    // Accessor untuk bulan tersisa (selalu integer)
    public function getMonthsLeftAttribute()
    {
        $now = Carbon::now();
        $endDate = Carbon::parse($this->tanggal_akhir);
        return (int) $now->diffInMonths($endDate, false);
    }

    // Accessor untuk hari tersisa (selalu integer)
    public function getRemainingDaysAttribute()
    {
        $now = Carbon::now();
        $endDate = Carbon::parse($this->tanggal_akhir);
        return (int) $now->diffInDays($endDate, false);
    }

    // Accessor: bagian waktu tersisa dalam bulan dan hari berbasis DateInterval
    public function getTimeLeftPartsAttribute(): array
    {
        $now = Carbon::now();
        $endDate = Carbon::parse($this->tanggal_akhir);
        $interval = $now->diff($endDate); // DateInterval

        // Total bulan = tahun*12 + bulan, hari = sisa hari pada interval
        $months = (int) ($interval->y * 12 + $interval->m);
        $days = (int) $interval->d;
        $sign = $interval->invert ? -1 : 1; // 1 jika future, -1 jika overdue

        return [
            'sign' => $sign,
            'months' => $months,
            'days' => $days,
        ];
    }

    // Cek apakah masih aktif
    public function isActive()
    {
        return $this->status === 'active' && $this->monthsLeft >= 0;
    }
}