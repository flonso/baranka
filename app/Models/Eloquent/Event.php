<?php

namespace App\Models\Eloquent;

use App\Models\Eloquent\BaseModel;

// TODO: Make this table more generic by replacing the hasOne Item relationship by hasOne Resource relationship (polymorphism ?)
class Event extends BaseModel
{
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The player that induced this event.
     */
    public function player() {
        return $this->belongsTo('App\Models\Eloquent\Player');
    }

    /**
     * The item that induced this event.
     */
    public function item() {
        return $this->belongsTo('App\Models\Eloquent\Item');
    }

    /**
     * The team that induced this event.
     */
    public function team() {
        return $this->belongsTo('App\Models\Eloquent\Team');
    }

    /**
     * The game phase during which the event was created.
     * This relationship is automatically filled using the current
     * phase if you use the provided helper functions for persisting models.
     */
    public function gamePhase() {
        return $this->belongsTo('App\Models\Eloquent\GamePhase');
    }

    public static function count() {
        return DB::table('events')->count();
    }

    public static function build(
        $value,
        string $eventType,
        $playerId = null,
        $teamId = null
    ) {
        $e = new Event();
        $e->type = $eventType;
        $e->value = $value;
        if (isset($playerId)) {
            $e->player()->associate($playerId);
        }

        if (isset($teamId)) {
            $e->team()->associate($teamId);
        }

        return $e;
    }
}
