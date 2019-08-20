<?php

namespace App\Models\Eloquent;

use App\Http\Requests\UpdatePlayerRequest;
use Illuminate\Support\Facades\DB;

class Player extends BaseModel
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
        return $this->belongsTo('App\Models\Eloquent\Team');
    }

    /**
     * The events that this player has induced.
     */
    public function events() {
        return $this->hasMany('App\Models\Eloquent\Event');
    }

    public static function count() {
        return DB::table('players')->count();
    }

    /**
     * Assigns the given data to the current player instance. For each field updated,
     * an event is generated so it can be stored in database.
     *
     * @return array An array of events generated for each data changed
     */
    public function updateFromData(UpdatePlayerRequest $update) {
        $events = [];

        if (isset($update->code)) {
            // No need to generate an event in this case
            $this->code = $update->code;
        }

        if (isset($update->scoreIncrement)) {
            $event = new Event();
            $event->value = $update->scoreIncrement;
            $event->type = ($event->value > 0) ? EventType::BONUS : EventType::MALUS;
            $event->player()->associate($this);

            $events[] = $event;

            $this->score += $update->scoreIncrement;
        }

        if (isset($update->level)) {
            $event = new Event();
            $event->value = 0;
            $event->type = EventType::LEVEL_CHANGE;
            $event->player()->associate($this);

            $events[] = $event;

            $this->level = $update->level;
        }

        if (isset($update->teamId)) {

        }

        return $events;
    }
}
