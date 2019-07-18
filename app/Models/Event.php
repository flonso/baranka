<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $incrementing = true;
    public $timestamps = true;

    /**
     * A value associated with this event. What is done with
     * the value is defined by the event's type.
     *
     * @var mixed
     */
    public $value;

    /**
     * The type of resource associated with this event.
     *
     * @var string
     */
    public $resource_type;


    /**
     * The type of the event.
     *
     * @var string
     */
    public $type;

    /**
     * A resource linked to this event.
     *
     * @var mixed
     */
    public $resource;

    public function getResourceAttribute($value) {
        // TODO: Fetch the resource from the value
    }

    public function setResourceAttribute($value) {
        // TODO: Update the resource with the value
    }

    public function player(): Player {
        return $this->hasOne('App\Models\Player');
    }

    /**
     * The team of the player that induced this event.
     *
     * @return Team
     */
    public function team(): Team {
        return $this->hasOneThrough(
            'App\Models\Team',
            'App\Models\Player'
        );
    }
}
