<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

use App\Exceptions\Validation\TeamValidationExceptions;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Eloquent\BaseModel;
use App\Models\Eloquent\Event;
use App\Models\Eloquent\EventType;

class Team extends BaseModel
{
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name', 'score', 'score_multiplier'
    ];

    protected $attributes = [
        'score' => 0,
        'score_multiplier' => 1.0
    ];

    /**
     * The name of the team.
     *
     * @var string
     */
    // public $name;

    /**
     * The team's score.
     * @var int
     */
    // public $score;

    /**
     * The multiplier applied to the team's score.
     *
     * @var double
     */
    // public $score_multiplier;

    /**
     * The members of the team.
     */
    public function players() {
        return $this->hasMany('App/Models/Player');
    }

    /**
     * The events that this team has induced.
     */
    public function events() {
        return $this->belongsTo('App\Models\Eloquent\Event');
    }

    public static function count() {
        return DB::table('teams')->count();
    }

    /**
     * Assigns the given data to the current team instance. For each field updated,
     * an event is generated so it can be stored in database.
     *
     * @return array An array of events generated for each data changed
     */
    public function updateFromData(UpdateTeamRequest $update) {
        $events = [];

        if (isset($update->scoreIncrement)) {
            $event = new Event();
            $event->value = $update->scoreIncrement;
            $event->type = ($event->value > 0) ? EventType::BONUS : EventType::MALUS;
            $events[] = $event;

            $this->score += $update->scoreIncrement;
        }

        if (isset($update->scoreMultiplierIncrement)) {
            $event = new Event();
            $event->value = $update->scoreMultiplierIncrement;
            $event->type = EventType::MULTIPLIER;
            $events[] = $event;

            $this->score_multiplier += $update->scoreMultiplierIncrement;
        }

        return $events;
    }
}
