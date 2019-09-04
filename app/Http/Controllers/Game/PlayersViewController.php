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
use GuzzleHttp\Client;

class PlayersViewController extends Controller
{
    public function get(Request $request)
    {
        /**
         * To use guzzle you need to have two instances of php artisan serve running.
         * In this example :8000 is used for the API and the other instance for the frontend testing.
         * See: https://stackoverflow.com/questions/48841018/guzzle-cannot-make-get-request-to-the-localhost-port-80-8000-8080-etc/57573002#57573002
         */
        $client = new Client([
            'base_uri' => 'http://localhost:8000'
        ]);

        $res = $client->request('GET', '/api/players');

        $response = json_decode($res->getBody()->getContents());
        $players = $response->data;
        $totalPlayers = $response->count;

        //pass param to view
        return view('players', ["players" => $players, 'totalPlayers' => $totalPlayers]);
    }
}
