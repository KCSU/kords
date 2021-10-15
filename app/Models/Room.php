<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    // TODO: Fillables for all the other models
    protected $fillable = [
        'number', 'floor',
        'available', 'long_contract',
        // 'band_id', 
    ];

    public function perks() {
        return $this->belongsToMany(Perk::class);
    }

    public function band() {
        return $this->belongsTo(Band::class);
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function ballot() {
        return $this->belongsTo(Ballot::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    public function images() {
        return $this->hasMany(Image::class);
    }
}
