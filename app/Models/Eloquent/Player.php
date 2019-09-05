<?php

namespace App\Models\Eloquent;

use App\Exceptions\ApiExceptions;
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
        return $this->belongsToMany('App\Models\Eloquent\Item');
    }

    public function completedItemAdventures() {
        return $this->belongsToMany('App\Models\Eloquent\Item', 'item_adventure_player');
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
     * Retrieves a player based on its id or its code.
     *
     * @param  int|string $idOrCode
     * @return App\Models\Eloquent\Player|null
     */
    public static function findByCodeOrId($idOrCode) {
        $player = DB::table('players')
            ->where('code', '=', $idOrCode)
            ->orWhere('id', '=', $idOrCode)
            ->first()
        ;

        if ($player != null) {
            $player = self::toInstance($player, new Player());
        }

        return $player;
    }

    /**
     * Retrieves a player based on its id or its code.
     * Aborts with a 404 error if no model is found.
     *
     * @param  int|string $idOrCode
     * @return App\Models\Eloquent\Player
     */
    public static function findByCodeOrIdOrFail($idOrCode) {
        $player = self::findByCodeOrId($idOrCode);

        if ($player == null) {
            abort(
                response()->json(
                    ApiExceptions::ModelNotFound("Player", $idOrCode)->toArray(),
                    404
                )
            );
        }

        return $player;
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value) {
        return self::findByCodeOrIdOrFail($value);
    }

    /**
     * Assigns the given data to the current player instance. For each field updated,
     * an event is generated so it can be stored in databaseo or used to impact other
     * models.
     *
     * @return array An array of events generated for each data changed
     */
    public function updateFromData(UpdatePlayerRequest $update) {
        $events = [];

        if (isset($update->code)) {
            // No need to generate an event in this case
            $this->code = $update->code;
        }

        if (isset($update->firstName)) {
            $this->first_name = $update->firstName;
        }

        if (isset($update->lastName)) {
            $this->last_name = $update->lastName;
        }

        // Will be erased if present but null
        if ($update->has('group')) {
            $this->group = $update->group;
        }

        // Will be erased if present but null
        if ($update->has('birthDate')) {
            $this->birth_date = $update->birthDate;
        }

        // Will be erased if present but null
        if ($update->has('comments')) {
            $this->comments = $update->comments;
        }

        if (isset($update->scoreIncrement)) {
            $events[] = $this->buildEvent(
                $update->scoreIncrement,
                EventType::MANUAL_POINTS
            );

            $this->score += $update->scoreIncrement;
        }

        if (isset($update->gainedQuestPoints)) {
            $events[] = $this->buildEvent(
                $update->gainedQuestPoints,
                EventType::QUEST
            );
            $this->score += $update->gainedQuestPoints;
        }

        if (isset($update->gainedBoardPoints)) {
            $events[] = $this->buildEvent(
                $update->gainedBoardPoints,
                EventType::BOARD
            );
            $this->score += $update->gainedBoardPoints;
        }

        if (isset($update->level) || (isset($update->levelUp) && $update->levelUp)) {
            $newLevel = $update->level ?? $this->level + 1;

            $evolutionGrid = config('game.evolution_grid');
            $scoreGain = $evolutionGrid[$newLevel] ?? 0;

            $events[] = $this->buildEvent(
                $scoreGain,
                EventType::LEVEL_CHANGE
            );

            $this->level = $newLevel;
        }

        if (isset($update->teamId)) {
            // Changing team is not supported yet.
        }

        return $events;
    }

    private function buildEvent($value, $type) {
        return Event::build(
            $value,
            $type,
            $this->id,
            $this->team_id
        );
    }
}
