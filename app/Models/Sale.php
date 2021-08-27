<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'user_id',
        'customer_id',
        'customer_name',
        'customer_address',
        'customer_phone',
        'date',
        'warranty_id',
        'discount_price',
        'discount_percent',
        'total_price',
        'payment_date',
        'sales_id',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function sale_detail()
    {
        return $this->hasMany('App\Models\SaleDetail');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
