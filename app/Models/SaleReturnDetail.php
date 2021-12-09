<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleReturnDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sale_return_dt';

    protected $fillable = [
        'sale_return_id',
        'sale_detail_id',
        'item_id',
        'sales_id',
        'buyer_id',
        'qty',
        'type',
        'description',
        'price',
        'total_price',
        'total_loss_store',
        'total_loss_sales',
        'total_loss_buyer',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function SaleReturn()
    {
        return $this->belongsTo(SaleReturn::class);
    }

    public function Item()
    {
        return $this->belongsTo(Item::class);
    }

    public function Buyer()
    {
        return $this->belongsTo('App\Models\Employee', 'buyer_id', 'id');
    }

    public function Sales()
    {
        return $this->belongsTo('App\Models\Employee', 'sales_id', 'id');
    }
}
