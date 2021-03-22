<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public function perks() {
        return $this->belongsToMany(Perk::class);
    }

    public function band() {
        return $this->belongsTo(Band::class);
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }
}
