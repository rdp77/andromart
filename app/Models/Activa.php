<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activa extends Model
{
    use HasFactory;
    protected $table = 'activa';
    protected $fillable = [
        'id',
        'code',
        'name',
        'location',
        'branch_id',
        'items_id',
        'items',
        'asset_id',
        'activa_group_id',
        'account_depreciation_id',
        'account_accumulation_id',
        'total_acquisition',
        'date_acquisition',
        'date_finished',
        'total_depreciation',
        'accumulation_depreciation',
        'remaining_depreciation',
        'total_early_depreciation',
        'description',
        'with_items',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];
    public function ItemsRel()
    {
        return $this->belongsTo('App\Models\Item', 'items_id', 'id');
    }
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
    public function ActivaGroup()
    {
        return $this->belongsTo('App\Models\ActivaGroup');
    }
    public function Asset()
    {
        return $this->belongsTo('App\Models\Asset');
    }
    public function ActivaDetail()
    {
        return $this->hasMany('App\Models\ActivaDetail');
    }
}
