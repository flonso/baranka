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
        'discovered',
        'adventure_completed'
    ];

    /**
     * The player that discovered the item.
     */
    public function discoveredByPlayers() {
        return $this->belongsToMany('App\Models\Eloquent\Player');
    }

    public function adventureCompletedByPlayers() {
        return $this->belongsToMany('App\Models\Eloquent\Player', 'item_adventure_player');
    }

    /**
     * The events that this item has induced.
     */
    public function events() {
        return $this->belongsTo('App\Models\Eloquent\Event');
    }

    public function getDiscoverableAttribute() {
        return $this->discoverable_from_phase <= GamePhase::current()->number;
    }

    public function getDiscoveredAttribute() {
        return $this->discoveredByPlayers != null && $this->discoveredByPlayers->count() > 0;
    }

    public function getAdventureCompletedAttribute() {
        return (
            $this->adventureCompletedByPlayers != null &&
            $this->adventureCompletedByPlayers->count() > 0
        );
    }

    /**
     * For each 2 phases the item is discoverable, the points
     * decrease by 100.
     *
     * @return integer
     */
    public function getCurrentDiscoveryPointsAttribute() {
        $currentPhaseNumber = GamePhase::current()->number;
        $points = $this->discovery_points;
        $points -= floor(max(0, $currentPhaseNumber - $this->discoverable_from_phase) / 2) * 100;

        return $points;
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
            $this->multiplier_increment = $update->multiplierIncrement;
        }

        if (isset($update->discoveredByPlayerIds) && !$this->discovered && $this->discoverable) {
            $nbOfPlayers = count($update->discoveredByPlayerIds);
            $players = Player::findByCodeOrId($update->discoveredByPlayerIds);

            $this->discoveredByPlayers()->attach($players);
            foreach ($players as $player) {
                $event = new Event();
                $event->item()->associate($this);
                $event->value = (double) $this->currentDiscoveryPoints / (double) $nbOfPlayers;
                $event->type = EventType::ITEM;
                $event->player()->associate($player);
                $event->team()->associate($player->team_id);

                $events[] = $event;
            }
        }

        if (
            isset($update->adventureCompletedByPlayerIds) &&
            !$this->adventureCompleted &&
            $this->discovered
        ) {
            $nbOfPlayers = count($update->adventureCompletedByPlayerIds);
            $players = Player::findByCodeOrId($update->adventureCompletedByPlayerIds);

            $this->adventureCompletedByPlayers()->attach($players);
            foreach ($players as $player) {
                $event = new Event();
                $event->item()->associate($this);
                $event->value = (double) $this->adventure_points / (double) $nbOfPlayers;
                $event->type = EventType::ITEM;
                $event->player()->associate($player);
                $event->team()->associate($player->team_id);

                $events[] = $event;
            }
        }

        return $events;
    }
}
