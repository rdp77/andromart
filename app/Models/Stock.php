<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'unit_id',
        'branch_id',
        'stock',
        'min_stock',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
}
