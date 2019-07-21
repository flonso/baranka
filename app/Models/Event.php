<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// TODO: Make this table more generic by replacing the hasOne Item relationship by hasOne Resource relationship (polymorphism ?)
class Event extends Model
{
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The player that induced this event.
     */
    public function player() {
        return $this->hasOne('App\Models\Player');
    }

    /**
     * The item that induced this event.
     */
    public function item() {
        return $this->hasOne('App\Models\Item');
    }

    /**
     * The team that induced this event.
     */
    public function team() {
        return $this->hasOne('App\Models\Team');
    }
}
