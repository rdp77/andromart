<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryBalance extends Model
{
    use HasFactory;
    protected $table = 'summary_balance';
    protected $fillable = [
        'id',
        'name',
        'date',
        'year',
        'total',
        'created_at',
        'updated_at',
        // 'created_by',
        // 'updated_by',
    ];
   
}
