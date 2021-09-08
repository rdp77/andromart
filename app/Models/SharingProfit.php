<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharingProfit extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'date_start',
        'date_end',
        'employe_id',
        'total',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
