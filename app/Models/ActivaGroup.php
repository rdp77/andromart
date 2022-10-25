<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivaGroup extends Model
{
    use HasFactory;
    protected $table = 'activa_group';
    protected $fillable = [
        'id',
        'name',
        'estimate_age',
        'depreciation_rate',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

}
