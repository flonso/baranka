<?php

namespace App\Models\Eloquent;

use Illuminate\Support\Facades\DB;

use App\Http\Requests\UpdateTeamRequest;
use App\Models\Eloquent\BaseModel;
use App\Models\Eloquent\Event;
use App\Models\Eloquent\EventType;
use stdClass;

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
        return Event::where('type', '=', $eventType)
            ->where('team_id', '=', $this->id)
            ->sum('value')
        ;
    }

    public static function count() {
        return DB::table('teams')->count();
    }

    public static function getAllScoresForEventTypes(array $types) {
        $allTeamScores = DB::table('events')
            ->selectRaw("events.team_id, teams.name, teams.score_multiplier, sum(value) as score, type")
            ->join("teams", "events.team_id", "=", "teams.id")
            ->whereIn('type', $types)
            ->groupBy("type", "team_id")
            ->orderBy('score', 'desc')
            ->get()
        ;

        $ranks = [];
        $teamsWithScore = [];
        foreach ($types as $type) {
            $ranks[$type] = 0;
            $teamsWithScore[$type] = [];
        }
        $rankingByCategory = [];
        foreach ($allTeamScores as $s) {
            $type = $s->type;
            if (!isset($rankingByCategory[$type])) {
                $rankingByCategory[$type] = [];
            }

            $teamsWithScore[$type][] = $s->team_id;
            $ranks[$type] += 1; // Works because allTeamScores is sorted by descending score
            $s->rank = $ranks[$type];

            if ($type == EventType::QUEST) {
                $s->gainedPoints = 350 - ($s->rank - 1) * 70;
            } else {
                $s->gainedPoints = 1000 - ($s->rank - 1) * 200;
            }

            $rankingByCategory[$type][] = $s;
        }

        // Add score of 0 for teams that didn't register a scoring event at this point
        foreach ($teamsWithScore as $type => $teamIds) {
            $missingTeams = Team::whereNotIn('id', $teamIds)->get();
            foreach ($missingTeams as $team) {
                $s = new stdClass();
                $s->team_id = $team->id;
                $s->name = $team->name;
                $s->score = 0;
                $s->gainedPoints = 0;
                $s->score_multiplier = $team->score_multiplier;
                $s->type = $type;
                $ranks[$type] += 1;
                $s->rank = $ranks[$type];
                $rankingByCategory[$type][] = $s;
            }
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
            $event->team()->associate($this->id);
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
