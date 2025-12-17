<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomor_surat',
        'judul',
        'pengirim',
        'tanggal_surat',
        'status',
        'disposisi',
        'tanggal_kasubbang',
        'tanggal_sekretaris',
        'tanggal_kepala',
        'tanggal_selesai',
        'tanggal_distribusi',
    ];

    protected $casts = [
        'tanggal_surat' => 'date:Y-m-d',
        'tanggal_kasubbang' => 'datetime',
        'tanggal_sekretaris' => 'datetime',
        'tanggal_kepala' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'tanggal_distribusi' => 'datetime',
    ];

    // Status workflow - 5 tahap
    public static $statusList = [
        'kasubbang_umum' => 'Kasubbang Umum',
        'sekretaris' => 'Sekretaris',
        'kepala' => 'Kepala',
        'selesai' => 'Selesai',
        'distribusi' => 'Distribusi',
    ];

    // Warna status dengan gradient profesional
    public static $statusColors = [
        'kasubbang_umum' => 'blue',
        'sekretaris' => 'purple',
        'kepala' => 'amber',
        'selesai' => 'green',
        'distribusi' => 'emerald',
    ];

    // Icon untuk setiap status
    public static $statusIcons = [
        'kasubbang_umum' => 'inbox',
        'sekretaris' => 'document-text',
        'kepala' => 'user-check',
        'selesai' => 'check-circle',
        'distribusi' => 'paper-airplane',
    ];

    // Get status label
    public function getStatusLabelAttribute()
    {
        return self::$statusList[$this->status] ?? $this->status;
    }

    // Get status color
    public function getStatusColorAttribute()
    {
        return self::$statusColors[$this->status] ?? 'gray';
    }

    // Get status icon
    public function getStatusIconAttribute()
    {
        return self::$statusIcons[$this->status] ?? 'document';
    }

    // Get next status
    public function getNextStatusAttribute()
    {
        $statuses = array_keys(self::$statusList);
        $currentIndex = array_search($this->status, $statuses);
        
        if ($currentIndex !== false && $currentIndex < count($statuses) - 1) {
            return $statuses[$currentIndex + 1];
        }
        
        return null;
    }

    // Check if can move to next status
    public function getCanMoveToNextAttribute()
    {
        return $this->next_status !== null;
    }

    // Get progress percentage
    public function getProgressPercentageAttribute()
    {
        $statuses = array_keys(self::$statusList);
        $currentIndex = array_search($this->status, $statuses);
        
        if ($currentIndex === false) {
            return 0;
        }
        
        return (($currentIndex + 1) / count($statuses)) * 100;
    }

    // Get workflow steps - optimized with cache
    public function getWorkflowStepsAttribute()
    {
        $cacheKey = "surat_workflow_{$this->id}_{$this->status}";
        
        return cache()->remember($cacheKey, 300, function () {
            $statuses = array_keys(self::$statusList);
            $currentIndex = array_search($this->status, $statuses);
            
            return collect($statuses)->map(function ($status, $index) use ($currentIndex) {
                $isCompleted = $index < $currentIndex;
                $isCurrent = $index === $currentIndex;
                
                return [
                    'status' => $status,
                    'label' => self::$statusList[$status],
                    'icon' => self::$statusIcons[$status],
                    'color' => self::$statusColors[$status],
                    'completed' => $isCompleted,
                    'current' => $isCurrent,
                    'date' => $this->getStatusDate($status),
                ];
            });
        });
    }

    // Clear cache when status changes
    protected static function booted()
    {
        static::updated(function ($surat) {
            if ($surat->wasChanged('status')) {
                // Clear old status cache
                $oldCacheKey = "surat_workflow_{$surat->id}_{$surat->getOriginal('status')}";
                cache()->forget($oldCacheKey);
                
                // Clear new status cache
                $newCacheKey = "surat_workflow_{$surat->id}_{$surat->status}";
                cache()->forget($newCacheKey);
            }
        });
    }

    // Get status date
    public function getStatusDate($status)
    {
        // Map status to correct date field
        $dateFieldMap = [
            'kasubbang_umum' => 'tanggal_kasubbang',
            'sekretaris' => 'tanggal_sekretaris',
            'kepala' => 'tanggal_kepala',
            'selesai' => 'tanggal_selesai',
            'distribusi' => 'tanggal_distribusi',
        ];
        
        $dateField = $dateFieldMap[$status] ?? null;
        return $dateField ? $this->getAttribute($dateField) : null;
    }
}
