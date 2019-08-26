<?php

namespace App\Models\Eloquent;

use App\Http\Requests\UpdateItemRequest;
use App\Models\Eloquent\BaseModel;
use Illuminate\Support\Facades\DB;

class Item extends BaseModel
{
    public $incrementing = true;
    public $timestamps = true;

    protected $attributes = [
        'multiplier_increment' => 0
    ];

    protected $appends = [
        'discovered'
    ];

    /**
     * The player that discovered the item.
     */
    public function discoveredByPlayers() {
        return $this->belongsToMany('App\Models\Eloquent\Player');
    }

    /**
     * The events that this item has induced.
     */
    public function events() {
        return $this->belongsTo('App\Models\Eloquent\Event');
    }

    public function getDiscoveredAttribute() {
        return $this->discoveredByPlayers->count() > 0;
    }

    public static function count() {
        return DB::table('items')->count();
    }

    /**
     * Assigns the given data to the current iteam instance. For each field updated,
     * an event is generated so it can be stored in database.
     *
     * @return array An array of events generated for each data changed
     */
    public function updateFromData(UpdateItemRequest $update) {
        $events = [];
        if (isset($update->name)) {
            $this->name = $update->name;
        }

        if (isset($update->certificateNumber)) {
            $this->certificate_number = $update->certificateNumber;
        }

        if (isset($update->discoveryPoints)) {
            // TODO: If the item was found, must query all related events in order to update the points
            $this->discovery_points = $update->discoveryPoints;
        }

        if (isset($update->adventurePoints)) {
            // TODO: If the item was found, must query all related events in order to update the points
            $this->adventure_points = $update->adventurePoints;
        }

        if (isset($update->multiplierIncrement)) {
            // TODO: If the item was found, must query all related events in order to update the points
            $this->multiplier_increment = $this->multiplierIncrement;
        }

        if (isset($update->foundByPlayerIds)) {
            $nbOfPlayers = count($update->foundByPlayerIds);

            if ($nbOfPlayers == 0) {
                // Mark item as not found
                // FIXME: Remove related events !
                $this->discoveredByPlayers()->detach();
            } else {
                $this->discoveredByPlayers()->detach();
                $this->discoveredByPlayers()->attach($update->foundByPlayerIds);
                foreach ($update->foundByPlayerIds as $playerId) {
                    $event = new Event();
                    $event->value = $this->discovery_points / $nbOfPlayers;
                    $event->type = EventType::ITEM_FOUND;
                    $event->player()->associate($playerId);

                    $events[] = $event;
                }
            }
        }

        return $events;
    }
}
