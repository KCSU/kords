<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perk extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name', 'icon'
    ];

    public function rooms() {
        return $this->belongsToMany(Room::class);
    }

    /**
     * Get the display name (without underscores) of the perk.
     */
    public function getDisplayNameAttribute() {
        return str_replace('_', ' ', ucwords($this->name, '_'));
    }
}
