<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicePayment extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'service_payment';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'id' ,
        'code',
        'user_id',
        'service_id',
        'date',
        'total',
        'type',
        'payment_method',
        'account',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function Service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id', 'id');
    }
    public function ServiceDetail()
    {
        return $this->hasMany('App\Models\ServiceDetail', 'service_id', 'id');
    }
    public function ServiceStatusMutation()
    {
        return $this->hasMany('App\Models\ServiceStatusMutation', 'service_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
