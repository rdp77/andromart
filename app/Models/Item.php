<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'category_id',
        'supplier_id',
        'buy',
        'sell',
        'discount',
        'image',
        'condition',
        'description',
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }
}
