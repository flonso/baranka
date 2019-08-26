<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiExceptions;
use App\Exceptions\GameExceptions;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Common\PaginationParameters;
use App\Models\Eloquent\GamePhase;
use App\Models\Eloquent\Player;
use App\Models\Eloquent\Team;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    /**
     * Display a listing of all players, paginated.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $params = new PaginationParameters(
            intval($request->input('page'))
        );

        $query = DB::table('players')
            ->offset($params->offset)
            ->limit($params->limit)
        ;

        return response()->json([
            'data' => $query->get(),
            'count' => Player::count()
        ]);
    }

    /**
     * Create a new player based on the posted data.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreatePlayerRequest $create)
    {
        $teamId = $create->teamId;
        $team = DB::table('teams')->find($teamId);

        if ($team != null) {
            $team = Team::toInstance($team, new Team());
        } else {
            return response(
                "There is no team with id '$teamId'",
                404
            );
        }

        $player = new Player();
        $player->code = $create->code;
        $player->first_name = $create->firstName;
        $player->last_name = $create->lastName;
        $player->level = 1;
        $player->score = 0;
        $player->team()->associate($team);

        if ($player->save()) {
            return response()->json(
                $player,
                201
            );
        }

        return response()->json(
            ApiExceptions::CouldNotSaveData()->toArray(),
            500
        );
    }

    /**
     * Return the matching player.
     * @param  \App\Models\Eloquent\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function get(Player $player) {
        return response()->json($player);
    }

    /**
     * Update the given player's data.
     *
     * @param  UpdatePlayerRequest  $update
     * @param  \App\Models\Eloquent\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlayerRequest $update, Player $player) {

        $events = $player->updateFromData($update);
        $allSaved = true;
        if (is_array($events) && count($events) > 0) {
            if ($gamePhase = GamePhase::current()) {
                foreach ($events as $e) {
                    $e->gamePhase()->associate($gamePhase);
                    $allSaved = $allSaved && $e->save();
                }
            } else {
                return response()->json(
                    GameExceptions::NoGamePhaseStarted()->toArray(),
                    400
                );
            }
        }

        $allSaved = $allSaved && $player->save();
        if ($allSaved) {
            return response()->json($player);
        }

        return response()->json(
            ApiExceptions::CouldNotSaveData()->toArray(),
            500
        );
    }
}
