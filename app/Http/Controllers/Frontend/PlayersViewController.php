<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiExceptions;
use App\Exceptions\GameExceptions;
use App\Helpers\HttpHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Common\PaginationParameters;
use App\Models\Eloquent\GamePhase;
use App\Models\Eloquent\Player;
use App\Models\Eloquent\Team;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class PlayersViewController extends Controller
{
    public function get(Request $request)
    {
        $uri = action('PlayerController@list', ['page' => 1, 'limit' => 10000], false);

        $response = HttpHelpers::get($uri);
        $json = HttpHelpers::bodyToJson($response);
        $players = $json->data;
        $totalPlayers = $json->count;

        //pass param to view
        return view('players', ["players" => $players, 'totalPlayers' => $totalPlayers]);
    }
}
