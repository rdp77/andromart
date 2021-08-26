<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceStatusMutation extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'service_status_mutation';
    public $incrementing = true;

    protected $fillable = [
        'id',
        'service_id', 
        'technician_id',
        'index',
        'status',
        'description' ,
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    public function Technician()
    {
        return $this->belongsTo(Employee::class, 'service_id', 'id');
    }
}
