<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'service';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'id' ,
        'code',
        'customer_id',
        'customer_name',
        'customer_address',
        'customer_phone',
        'date',
        'brand',
        'series',
        'type',
        'no_imei',
        'damage',
        'clock',
        'total_service',
        'total_part',
        'total_downpayment',
        'discount_price',
        'discount_percent',
        'total_price',
        'downpayment_date',
        'payment_date',
        'work_status',
        'equipment',
        'done',
        'pickup_date',
        'warranty',
        'technician_id',
        'created_by',
        'updated_by',
        'created_at' ,
        'updated_at' ,
    ];
}
