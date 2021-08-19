<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceDetail extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'service_detail';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'id',
        'service_id', 
        'item_id',
        'price',
        'qty',
        'total_pice',
        'description' ,
        'type' ,
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
