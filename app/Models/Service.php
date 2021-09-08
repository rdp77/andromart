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
        'user_id',
        'branch_id',
        'customer_id',
        'customer_name',
        'customer_address',
        'customer_phone',
        'date',
        'brand',
        'series',
        'type',
        'no_imei',
        'complaint',
        'clock',
        'total_service',
        'total_part',
        'discount_price',
        'discount_percent',
        'total_price',
        'total_downpayment',
        'total_payment',
        'downpayment_date',
        'payment_date',
        'work_status',
        'equipment',
        'payment_status',
        'pickup_date',
        'warranty_id',
        'technician_id',
        'technician_replacement_id',
        'estimate_date',
        'description',
        'verification_price',
        'total_loss',
        'total_loss_technician_1',
        'total_loss_technician_2',
        'total_loss_store',
        'sharing_profit_status',
        'sharing_profit_store',
        'sharing_profit_technician_1',
        'sharing_profit_technician_2',
        'total_price',
        'created_by',
        'updated_by',
        'created_at' ,
        'updated_at' ,
    ];

    public function ServiceDetail()
    {
        return $this->hasMany('App\Models\ServiceDetail', 'service_id', 'id');
    }
    public function ServicePayment()
    {
        return $this->hasMany('App\Models\ServicePayment', 'service_id', 'id');
    }
    public function ServiceStatusMutation()
    {
        return $this->hasMany('App\Models\ServiceStatusMutation', 'service_id', 'id');
    }
    public function Employee1()
    {
        return $this->belongsTo('App\Models\Employee', 'technician_id', 'id');
    }
    public function Employee2()
    {
        return $this->belongsTo('App\Models\Employee', 'technician_replacement_id', 'id');
    }
    public function CreatedByUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
