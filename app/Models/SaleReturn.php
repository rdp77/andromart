<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleReturn extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sale_return';

    protected $fillable = [
        'sale',
        'item',
        'type',
        'desc',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function Sale()
    {
        return $this->belongsTo(Sale::class, 'sale', 'id');
    }

    public function Item()
    {
        return $this->belongsTo(Item::class, 'item', 'id');
    }
}