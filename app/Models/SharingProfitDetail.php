<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharingProfitDetail extends Model
{
    use HasFactory;
    protected $table = 'sharing_profit_detail';
    protected $fillable = [
        'id',
        'service_id',
        'sharing_profit_id',
        'total',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function SharingProfit()
    {
        return $this->belongsTo('App\Models\SharingProfit', 'sharing_profit_id', 'id');
    }
}
