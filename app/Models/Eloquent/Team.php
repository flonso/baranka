<?php

namespace App\Models\Eloquent;

use Illuminate\Support\Facades\DB;

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

    public function getScoreByEventType(string $eventType) {
        return DB::table('events')
            ->where('type', '=', $eventType)
            ->where('team_id', '=', $this->id)
            ->sum('value')
        ;
    }

    public static function count() {
        return DB::table('teams')->count();
    }

    public static function getAllScoresForEventTypes(array $types) {
        $allTeamScores = DB::table('events')
            ->selectRaw("events.team_id, teams.name, sum(value) as score, type")
            ->join("teams", "events.team_id", "=", "teams.id")
            ->whereIn('type', $types)
            ->groupBy("type", "team_id")
            ->orderBy('score', 'desc')
            ->get()
        ;

        $ranks = [];
        foreach ($types as $type) {
            $ranks[$type] = 0;
        }
        $rankingByCategory = [];
        foreach ($allTeamScores as $s) {
            $type = $s->type;
            if (!isset($rankingByCategory[$type])) {
                $rankingByCategory[$type] = [];
            }

            $ranks[$type] += 1; // Works because allTeamScores is sorted by descending score
            $s->rank = $ranks[$type];
            $rankingByCategory[$type][] = $s;
        }

        return $rankingByCategory;
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
            $event->type = EventType::MANUAL_POINTS;
            $events[] = $event;

            $this->score += $update->scoreIncrement;
        }

        if (isset($update->scoreMultiplierIncrement)) {

            $this->score_multiplier += $update->scoreMultiplierIncrement;
        }

        return $events;
    }

    public function resolveRouteBinding($value) {
        return parent::resolveRouteBinding($value);
    }
}
