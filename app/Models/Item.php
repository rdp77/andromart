<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'items';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'id',
        'name',
        'brand_id',
        'supplier_id',
        'warranty_id',
        'buy',
        'sell',
        'discount',
        'image',
        'condition',
        'description',
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

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    public function stock()
    {
        return $this->hasMany('App\Models\Stock');
    }

    public function stocks()
    {
        return $this->belongsTo('App\Models\Stock');
    }

    public function getImage()
    {
        if (!$this->avatar) {
            return asset('assetsmaster/avatar/avatar.png');
        }
        return asset('assetsmaster/image/item/' . $this->image);
    }

    public function SaleDetail()
    {
        return $this->hasMany('App\Models\SaleDetail');
    }

    public function ReturnDetail()
    {
        return $this->hasMany(SaleReturnDetail::class);
    }

    public function warranty()
    {
        return $this->belongsTo('App\Models\Warranty');
    }
}