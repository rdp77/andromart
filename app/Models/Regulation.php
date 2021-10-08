<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'types_id',
        'role_id',
        'branch_id',
        'date',
        'title',
        'description',
        'file',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}