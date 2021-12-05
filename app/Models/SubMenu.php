<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    protected $table = 'submenu';
    public $timestamps = false;

    protected $fillable = [
        'menu_id',
        'name',
        'url',
        'hover'
    ];

    public function Menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }
    public function RoleDetail()
    {
        return $this->hasMany(RoleDetail::class, 'menu', 'id');
    }
}
