<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'code',
        'user_id',
        'branch_id',
        'customer_id',
        'customer_name',
        'customer_address',
        'customer_phone',
        'date',
        'warranty_id',
        'discount_type',
        'discount_price',
        'discount_percent',
        'item_price',
        'total_price',
        'sales_id',
        'sharing_profit_store',
        'sharing_profit_sales',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function SaleDetail()
    {
        return $this->hasMany('App\Models\SaleDetail');
    }

    public function SharingProfitDetail()
    {
        return $this->hasMany('App\Models\SharingProfitDetail');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    public function Branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
}
