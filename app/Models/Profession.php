<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;

    protected $table = 'profession';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
