<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryJournal extends Model
{
    use HasFactory;
    protected $table = 'summary_journals';
    protected $fillable = [
        'id',
        'account_data',
        'account_main_id',
        'account_detail_id',
        'date',
        'branch_id',
        'year',
        'total',
        'created_at',
        'updated_at',
    ];
   
}
