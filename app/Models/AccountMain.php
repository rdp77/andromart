<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class accountMain extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'account_main';
    protected $fillable = [
        'id',
        'code',
        'name',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];
}
