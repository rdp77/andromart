<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleDetail extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'roles_detail';
    protected $fillable = [
        'id',
        'roles_id',
        'menu',
        'view',
        'create',
        'edit',
        'delete',
        'created_at',
        'updated_at',
        // 'deleted_at',
        'created_by',
        'updated_by',
        // 'deleted_by',
    ];

}
