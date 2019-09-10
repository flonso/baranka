<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiExceptions;
use App\Exceptions\BaseException;
use App\Models\Eloquent\Team;
use App\Models\Eloquent\GamePhase;
use App\Models\Common\PaginationParameters;
use App\Exceptions\GameExceptions;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Eloquent\EventType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of all teams, paginated.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {
        $params = new PaginationParameters(
            intval($request->input('page'))
        );

        $query = DB::table('teams')
            ->offset($params->offset)
            ->limit($params->limit)
        ;

        return response()->json([
            'data' => $query->get(),
            'count' => Team::count()
        ]);
    }

    /**
     * Create a new team from the posted data
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateTeamRequest $create) {
        $team = new Team();
        $team->name = $create->name;
        $team->score = $create->initialScore;
        $team->score_multiplier = $create->initialScoreMultiplier;

        if ($team->save()) {
            return response()->json(
                $team,
                201
            );
        }

        return response()->json(
            ApiExceptions::CouldNotSaveData()->toArray(),
            500
        );
    }

    /**
     * Return the given team.
     *
     * @param  \App\Models\Eloquent\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function get(Team $team) {
        return response()->json($team);
    }

    /**
     * Update the given team with patch data
     *
     * @param  \App\Models\Eloquent\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $update, Team $team) {
        $events = $team->updateFromData($update);
        $models = [$team];

        return $this->persistModels(
            array_merge($events, $models),
            $team
        );
    }

    /**
     * Returns the ranking for each category of event in the game.
     */
    public function rankings(Request $request) {
        $eventTypes =  [
            EventType::ITEM,
            EventType::LEVEL_CHANGE,
            EventType::QUEST,
            EventType::BOARD
        ];
        $rankings = Team::getAllScoresForEventTypes(
            $eventTypes
        );

        return response()->json($rankings);
    }

    /**
     * Returns the final ranking for the game. This takes into account individual ranks
     * in each event category, applies manual points and finally applies each team's score
     * multiplier.
     *
     * Use this to know who is winning.
     */
    public function globalRanking(Request $request) {
        $eventTypes =  [
            EventType::ITEM,
            EventType::LEVEL_CHANGE,
            EventType::QUEST,
            EventType::BOARD
        ];

        // Indexes are EventType
        // FIXME: What about equalities ?
        $rankings = Team::getAllScoresForEventTypes(
            $eventTypes
        );

        // Assign points based on rank for each event type
        $finalScoresByTeam = [];
        foreach ($rankings as $type => $rank) {
            foreach ($rank as $score) {
                $teamId = $score->team_id;
                if (!isset($finalScoresByTeam[$teamId])) {
                    $finalScoresByTeam[$teamId] = 0;
                }

                if ($type == EventType::QUEST) {
                    $finalScoresByTeam[$teamId] += $score->gainedPoints;
                } else {
                    $finalScoresByTeam[$teamId] += $score->gainedPoints;
                }
            }
        }


        $teams = Team::find(array_keys($finalScoresByTeam));
        $teamsById = [];
        foreach ($teams as $team) {
            $teamsById[$team->id] = $team;
        }

        // Assign rank + final score to each team
        $ranks = range(1, count($finalScoresByTeam));
        $finalScoresByTeam = array_sort($finalScoresByTeam, function($score) { return -$score; });
        $teamsWithScores = array_map(function($score, $teamId) use ($teamsById) {
            $team = $teamsById[$teamId];
            $manualPoints = $team->getScoreByEventType(EventType::MANUAL_POINTS);
            $team->score = ($score + $manualPoints) * $team->score_multiplier;
            return $team;
        }, $finalScoresByTeam, array_keys($finalScoresByTeam));

        $teamsWithScoresAndRanks = array_map(function($team, $rank) {
            $team->rank = $rank;
            return $team;
        }, $teamsWithScores, $ranks);

        return response()->json($teamsWithScoresAndRanks);
    }

    /**
     * Returns the rankinf of each team for a given event type.
     */
    public function rankingForCategory(Request $request, $type) {
        $teamScoresByCategory = Team::getAllScoresForEventTypes([$type]);

        return response()->json(
            $teamScoresByCategory[$type]
        );
    }
}
