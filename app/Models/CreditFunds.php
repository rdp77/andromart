<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditFunds extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'credit_funds_pdl';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'sales_id',
        'liquid_date',
        'total',
        'accepted',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
