<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivaDetail extends Model
{
    use HasFactory;
    protected $table = 'activa_detail';
    protected $fillable = [
        'id',
        'activa_id',
        'total_depreciation',
        'period_depreciation',
        'branch_id',
        'account_depreciation_id',
        'account_accumulation_id',
        'ref_journals',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function Branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
    public function AccountDepreciation()
    {
        return $this->belongsTo('App\Models\AccountData','account_depreciation_id', 'id');
    }
    public function AccountAccumulation()
    {
        return $this->belongsTo('App\Models\AccountData', 'account_accumulation_id', 'id');
    }
    public function Journals()
    {
        return $this->belongsTo('App\Models\Journal', 'ref_journals', 'code');
    }

}
