<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'stocks_transaction';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'id',
        'item_id',
        'unit_id',
        'branch_id',
        'qty',
        'type',
        'reason',
        'date',
        'code',
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
    public function stock()
    {
        return $this->belongsTo('App\Models\Stock');
    }
}
