<?php

namespace App\Http\Controllers;

use App\Exceptions\BaseException;
use App\Models\Team;
use App\Models\Eloquent\GamePhase;
use App\Models\Common\PaginationParameters;
use App\Exceptions\GameExceptions;

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

        $data = $query->get();

        return response()->json([
            'data' => $data,
            'count' => Team::count()
        ]);
    }

    /**
     * Create a new team from the posted data
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $data = $request->json()->all();

        $team = new Team();
        $team->name = $data['name'];
        $team->score = $data['initialScore'];
        $team->score_multiplier = $data['initialScoreMultiplier'];

        $team->save();
    }

    /**
     * Return the given team.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function get(Team $team)
    {
        if ($team) {
            return response()->json($team);
        } else {
            return response(
                'The requested resource could not be found.',
                404
            );
        }
    }

    /**
     * Update the given team with patch data
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        if ($team) {
            $data = $request->json()->all();

            try {
                $data = Team::isUpdateValid($data);
            } catch (BaseException $e) {
                return response()->json(
                    $e->toArray(),
                    400
                );
            }

            $events = $team->updateFromData($data);

            if (is_array($events) && count($events) > 0) {
                if ($gamePhase = GamePhase::current()) {
                    foreach ($events as $e) {
                        $e->gamePhase()->associate($gamePhase);
                        $e->save();
                    }
                } else {
                    return response()->json(
                        GameExceptions::NoGamePhaseStarted()->toArray(),
                        400
                    );
                }
            }

            $team->save();

            return response()->json($team);
        } else {
            return response(
                'The requested resource could not be found.',
                404
            );
        }
    }
}
