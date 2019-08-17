<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $incrementing = true;
    public $timestamps = true;

    protected $attributes = [
        'multiplier_increment' => 0,
        'discovered' => false
    ];

    /**
     * The player that discovered the item.
     */
    public function discoveredBy() {
        return $this->belongsTo('App\Models\Eloquent\Player', 'discovered_by_id');
    }

    /**
     * The events that this item has induced.
     */
    public function events() {
        return $this->belongsTo('App\Models\Eloquent\Event');
    }
}
