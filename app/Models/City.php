<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'city';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'code',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
