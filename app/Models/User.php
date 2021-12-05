<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

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

    public function akses($namaFitur,$namaPerintah)
    {
        $hak_akses = new \App\Models\RoleDetail();

        $data = $hak_akses
                  ->where('menu',$namaFitur)
                  ->where($namaPerintah,'on')
                  ->where('roles_id',Auth::user()->role_id)
                  ->first();
        if (empty($data)) {
            return 'akses ditolak';
        }else{
            return 'akses diterima';
        }
    }
}
