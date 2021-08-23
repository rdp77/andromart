<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'category_id',
        'branch_id',
        'supplier_id',
        'buy',
        'sell',
        'discount',
        'image',
        'status',
        'description',
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }
}
