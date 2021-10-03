<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountData extends Model
{
    use HasFactory;
    protected $table = 'account_data';
    protected $fillable = [
        'id',
        'code',
        'name',
        'area_id',
        'branch_id',
        'debet_kredit',
        'active',
        'account_type',
        'main_id',
        'main_detail_id',
        'opening_balance',
        'opening_date',
        'created_at',
        'updated_at',
        // 'created_by',
        // 'updated_by',
    ];
}
