<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $incrementing = true;
    public $timestamps = true;

    protected $attributes = [
        'level' => 1,
        'score' => 0,
    ];

    public function discoveredItems() {
        return $this->hasMany('App\Models\Item', 'discovered_by_id');
    }

    public function team() {
        return $this->belongsTo('App\Models\Team');
    }

    /**
     * The events that this player has induced.
     */
    public function events() {
        return $this->belongsTo('App\Models\Event');
    }
}
