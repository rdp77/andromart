<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $table = 'installment';
    public $timestamps = false;

    protected $fillable = [
        'info',
        'active'
    ];
}
