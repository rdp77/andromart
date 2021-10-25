<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceReturn extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'service_return';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'id' ,
        'code',
        'user_id',
        'date',
        'service_id',
        'description',
        'type',
        'created_by',
        'updated_by',
        'created_at' ,
        'updated_at' ,
    ];

    public function ServiceDetail()
    {
        return $this->hasMany('App\Models\ServiceDetail', 'service_id', 'id');
    }
    
    public function ServiceEquipment()
    {
        return $this->hasMany('App\Models\ServiceEquipment', 'service_id', 'id');
    }
    public function ServiceCondition()
    {
        return $this->hasMany('App\Models\ServiceCondition', 'service_id', 'id');
    }
    public function ServicePayment()
    {
        return $this->hasMany('App\Models\ServicePayment', 'service_id', 'id');
    }
    public function ServiceStatusMutation()
    {
        return $this->hasMany('App\Models\ServiceStatusMutation', 'service_id', 'id');
    }
    public function SharingProfitDetail()
    {
        return $this->hasMany('App\Models\SharingProfitDetail', 'service_id', 'id');
    }
    public function LossItemsDetail()
    {
        return $this->hasMany('App\Models\LossItemsDetail', 'service_id', 'id');
    }
    public function Brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand', 'id');
    }
    public function Service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id', 'id');
    }
    public function Type()
    {
        return $this->belongsTo('App\Models\Type', 'series', 'id');
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
