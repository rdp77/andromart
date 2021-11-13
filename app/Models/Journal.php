<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;
    protected $table = 'journals';
    protected $fillable = [
        'id',
        'code',
        'total',
        'year',
        'date',
        'type',
        'ref',
        'description',
        'created_at',
        'updated_at',
        // 'created_by',
        // 'updated_by',
    ];
    public function JournalDetail()
    {
        return $this->hasMany('App\Models\JournalDetail', 'journal_id', 'id');
    }
    public function ServicePayment()
    {
        return $this->belongsTo('App\Models\ServicePayment', 'ref', 'code');
    }
    public function Sale()
    {
        return $this->belongsTo('App\Models\Sale', 'ref', 'code');
    }
}
