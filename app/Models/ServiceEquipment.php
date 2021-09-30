<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceEquipment extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'service_equipment';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'id' ,
        'name' ,
        'service_id' ,
        'status' ,
        'description' ,
        'created_by',
        'updated_by',
        'created_at' ,
        'updated_at' ,
    ];
}
