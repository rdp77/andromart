<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accountMainDetail extends Model
{
    use HasFactory;

    protected $table = 'account_main_detail';
    protected $fillable = [
        'id',
        'main_id',
        'code',
        'name',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function main()
    {
        return $this->belongsTo('App\Models\AccountMain', 'main_id', 'id');
    }
    public function accountData()
    {
        return $this->hasMany('App\Models\AccountData', 'main_detail_id', 'id');
    }
    
}
