<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accountMainDetail extends Model
{
    use HasFactory;
    protected $table = 'account_main_detail';
    protected $fillable = [
        'id',
        'main_id',
        'code',
        'name',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];
}
