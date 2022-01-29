<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = true;

    protected $fillable = [
        'id',
        'sale_id',
        'item_id',
        'price',
        'qty',
        'total',
        'hpp',
        'total_hpp',
        'sales_id',
        'buyer_id',
        'sharing_profit_store',
        'sharing_profit_sales',
        'sharing_profit_buyer',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function Sale()
    {
        return $this->belongsTo('App\Models\Sale');
    }

    public function Item()
    {
        return $this->belongsTo('App\Models\Item');
    }

    public function Buyer()
    {
        return $this->belongsTo('App\Models\Employee');
    }
}
