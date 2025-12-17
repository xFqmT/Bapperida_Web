<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Meeting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'agenda', 'pic', 'date', 'start_time', 'end_time', 'status', 'notes', 'ruang_rapat'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    protected function dayName(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->date) return null;
            return Carbon::parse($this->date)->locale('id')->translatedFormat('l');
        });
    }
}
