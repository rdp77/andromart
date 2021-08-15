<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'member';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'identity',
        'gender',
        'birth_place',
        'birth_date',
        'status',
        'religion',
        'department',
        'profession',
        'address',
        'city',
        'telp',
        'register_date',
        'role_id',
        'active',
        'image',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
