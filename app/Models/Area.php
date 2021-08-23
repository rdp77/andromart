<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'created_at',
        'updated_at',
    ];

    public function branch()
    {
        return $this->hasMany('App\Models\Branch');
    }
}
