<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingPresentase extends Model
{
    protected $table = 'setting_presentase';
    use HasFactory;
    protected $fillable = [
      'name',
      'total',
      'created_at',
      'updated_at',
      'updated_by',
      'created_by',
    ];

}
