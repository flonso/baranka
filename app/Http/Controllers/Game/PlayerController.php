<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiExceptions;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePlayerRequest;
use App\Models\Common\PaginationParameters;
use App\Models\Eloquent\BaseModel;
use App\Models\Eloquent\Player;
use App\Models\Team;
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

        $data = $query->get();

        return response()->json([
            'data' => $data,
            'count' => Player::count()
        ]);
    }

    /**
     * Create a new player based on the posted data.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreatePlayerRequest $request)
    {
        $input = $request->json()->all();

        $teamId = $input['teamId'];
        $team = DB::table('teams')->find($teamId);

        if ($team == null) {
            return response(
                "There is no team with id '$teamId'",
                404
            );
        } else {
            $team = Team::toInstance($team, new Team());
        }

        $player = new Player();
        $player->code = $input['code'];
        $player->first_name = $input['firstName'];
        $player->last_name = $input['lastName'];
        $player->level = 1;
        $player->score = 0;
        $player->team()->associate($team);

        $saved = $player->save();

        if (!$saved) {
            return response()->json(
                ApiExceptions::CouldNotSaveData()->toArray(),
                500
            );
        }

        return response()->json($player);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Eloquent\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Eloquent\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Eloquent\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player $player)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Eloquent\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        //
    }
}
