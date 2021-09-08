<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'cost_id',
        'branch_id',
        'cash_id',
        'price',
        'date',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function cost()
    {
        return $this->belongsTo('App\Models\Cost');
    }

    public function cash()
    {
        return $this->belongsTo('App\Models\Cash');
    }
}
