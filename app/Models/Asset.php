<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $table = 'asset';
    protected $fillable = [
        'id',
        'name',
        'account_depreciation_id',
        'account_accumulation_id',
        'description',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];
    public function AccountDepreciation()
    {
        return $this->belongsTo('App\Models\AccountMainDetail');
    }
    public function AccountAccumulation()
    {
        return $this->belongsTo('App\Models\AccountMainDetail');
    }
}
