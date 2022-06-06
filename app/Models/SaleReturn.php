<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use HasFactory;

    protected $table = 'sale_return';

    protected $fillable = [
        'id',
        'code',
        'sale_id',
        'item_id',
        'date',
        'type',
        'description',
        'payment_method',
        'account',
        'item_price_old',
        'item_price',
        'total_price',
        'total_loss_store',
        'total_loss_sales',
        'total_loss_buyer',
        'discount_type',
        'discount_price',
        'discount_percent',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function Sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }

    public function SaleReturnDetail()
    {
        return $this->hasMany(SaleReturnDetail::class, 'sale_return_id', 'id');
    }
}
