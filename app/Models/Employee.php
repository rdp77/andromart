<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'identity',
        'name',
        'contact',
        'address',
        'level',
        'gender',
        'birthday',
        'avatar',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function Service1()
    {
        // return $this->hasMany('App\Models\Service','');
        return $this->hasMany('App\Models\Service', 'technician_id', 'id');
    }
    public function Service2()
    {
        // return $this->hasMany('App\Models\Service','');
        return $this->hasMany('App\Models\Service', 'technician_replacement_id', 'id');
    }

    // public function Employee1()
    // {
    //     return $this->belongsTo('App\Models\Employee', 'technician_id', 'id');
    // }
    // public function Employee2()
    // {
    //     return $this->belongsTo('App\Models\Employee', 'technician_replacement_id', 'id');
    // }
    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function Role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function SaleDetail()
    {
        return $this->hasMany('App\Models\SaleDetail');
    }

    public function getAvatar()
    {
        if(!$this->avatar){
            return asset('assetsmaster/avatar/avatar.png');
        }
        return asset('assetsmaster/avatar/'. $this->avatar);
    }
}
