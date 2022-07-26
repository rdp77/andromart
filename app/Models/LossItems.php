<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LossItems extends Model
{
    use HasFactory;
    protected $table = 'loss_items';
    protected $fillable = [
        'id',
        'code',
        'date',
        'date_start',
        'date_end',
        'employe_id',
        'total',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function Technician()
    {
        return $this->belongsTo('App\Models\Employee', 'employe_id', 'id');
    }
    public function LossItemsDetail()
    {
        return $this->hasMany('App\Models\lossItemsDetail', 'loss_items_id', 'id');
    }
}
