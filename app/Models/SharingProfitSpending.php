<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharingProfitSpending extends Model
{
    use HasFactory;
    protected $table = 'sharing_profit_spending';
    protected $fillable = [
        'id',
        'code',
        'ref',
        // 'loss_id',
        'date',
        'subtraction_total',
        'total',
        'employe_id',
        'description',
        'created_at',
        'created_by',
    ];

    public function Technician()
    {
        return $this->belongsTo('App\Models\Employee', 'employe_id', 'id');
    }
    public function SharingProfit()
    {
        return $this->belongsTo('App\Models\SharingProfit', 'sharing_profit_id', 'id');
    }
}
