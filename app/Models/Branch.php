<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'name',
        'code',
        'address',
        'created_at',
        'updated_at',
    ];
}
