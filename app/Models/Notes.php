<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;
    // protected $table = 'notes';

    protected $fillable = [
        'users_id',
        'date',
        'title',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function notesPhoto()
    {
        return $this->hasMany('App\Models\NotesPhoto');
    }
}
