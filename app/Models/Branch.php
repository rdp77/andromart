<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'name',
        'code',
        'address',
        'phone',
        'email',
        'latitude',
        'longitude',
        'title',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function customer()
    {
        return $this->hasMany('App\Models\Customer');
    }

    public function employee()
    {
        return $this->hasMany('App\Models\Employee');
    }

    public function stock()
    {
        return $this->hasMany('App\Models\Stock');
    }

    public function payment()
    {
        return $this->hasMany('App\Models\Payment');
    }
}
