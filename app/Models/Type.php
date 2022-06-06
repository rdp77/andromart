<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'brand_id',
      'created_at',
      'updated_at',
      'updated_by',
      'created_by',
    ];

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

}
