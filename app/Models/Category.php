<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'created_at',
        'updated_at',
    ];

    public function item()
    {
        return $this->hasMany('App\Models\Item');
    }
}
