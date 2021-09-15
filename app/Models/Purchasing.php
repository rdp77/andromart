<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasing extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',

        'date',
        'price',
        'discount',
        'code',
        'status',
        
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function purchasingDetail()
    {
        return $this->hasMany('App\Models\PurchasingDetail');
    }
}
