<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;
    public $incrementing = true;

    protected $fillable = [
        'id',
        'sale_id',
        'item_id',
        'price',
        'qty',
        'total',
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
}
