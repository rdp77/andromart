<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role_id',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function sale()
    {
        return $this->belongsTo('App\Models\Sale');
    }

    public function employee()
    {
        return $this->hasOne('App\Models\Employee');
    }

    public function Role()
    {
        return $this->belongsTo('App\Models\Role');
    }
}
