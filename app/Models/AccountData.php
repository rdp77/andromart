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

    public function AccountMain()
    {
        return $this->belongsTo(AccountMain::class, 'main_id', 'id');
    }
    public function AccountMainDetail()
    {
        return $this->belongsTo(AccountMainDetail::class, 'main_detail_id', 'id');
    }
    public function Branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
    
}
