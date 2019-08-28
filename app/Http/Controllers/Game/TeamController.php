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
}
