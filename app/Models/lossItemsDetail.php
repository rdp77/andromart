<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LossItemsDetail extends Model
{
    use HasFactory;
    protected $table = 'loss_items_detail';
    protected $fillable = [
        'id',
        'service_id',
        'loss_items_id',
        'total',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function LossItems()
    {
        return $this->belongsTo('App\Models\LossItems', 'loss_items_id', 'id');
    }
    public function Service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id', 'id');
    }
}
