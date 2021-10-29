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
        'id',
        'code',
        'user_id',
        // 'cash_id',
        'branch_id',
        'customer_id',
        'customer_name',
        'customer_address',
        'customer_phone',
        'date',
        'discount_type',
        'discount_price',
        'discount_percent',
        'payment_method',
        'item_price',
        'total_price',
        'sales_id',
        'total_profit_store',
        'total_profit_sales',
        'total_profit_buyer',
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
        return $this->hasMany('App\Models\SaleDetail', 'sale_id', 'id');
    }

    public function SharingProfitDetail()
    {
        return $this->hasMany('App\Models\SharingProfitDetail');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    public function Sales()
    {
        return $this->belongsTo('App\Models\Employee', 'sales_id', 'id');
    }

    public function Buyer()
    {
        return $this->belongsTo('App\Models\Employee', 'buyer_id', 'id');
    }

    public function Branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function Warranty()
    {
        return $this->belongsTo('App\Models\Warranty');
    }

    public function Customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }

    public function CreatedByUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function Cash()
    {
        return $this->belongsTo('App\Models\Cash');
    }
}