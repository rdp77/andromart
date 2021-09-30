<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'icon',
        'url',
        'hover'
    ];

    public function SubMenu()
    {
        return $this->hasMany(SubMenu::class, 'menu_id', 'id');
    }
}
