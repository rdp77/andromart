<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalDetail extends Model
{
    use HasFactory;
    protected $table = 'journal_details';
    protected $fillable = [
        'id',
        'journal_id',
        'account_id',
        'total',
        'description',
        'debet_kredit',
        'created_at',
        'updated_at',
        // 'created_by',
        // 'updated_by',
    ];
    public function Journal()
    {
        return $this->belongsTo('App\Models\Journal', 'journal_id', 'id');
    }
    public function AccountData()
    {
        return $this->belongsTo(AccountData::class, 'account_id', 'id');
    }
}
