<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Common\PaginationParameters;
use App\Models\Eloquent\Player;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
