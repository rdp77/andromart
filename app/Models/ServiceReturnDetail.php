<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceReturnDetail extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'service_return_detail';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'id',
        'service_return_id', 
        'item_id',
        'price',
        'qty',
        'total_price',
        'treatment',
        'description' ,
        'type' ,
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    public function Items()
    {
        return $this->belongsTo('App\Models\Item', 'item_id', 'id');
    }
}
