<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DashboardSlide extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image_path', 'caption', 'order', 'is_active'
    ];
}
