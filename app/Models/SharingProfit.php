<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharingProfit extends Model
{
    use HasFactory;
    protected $table = 'sharing_profit';
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
    public function SharingProfitDetail()
    {
        return $this->hasMany('App\Models\SharingProfitDetail', 'sharing_profit_id', 'id');
    }
}
