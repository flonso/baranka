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

class PlayersViewController extends Controller
{
    public function get(Request $request)
    {
        $players = app('app/Http/Controllers/PlayerController')->list();
        //pass param to view
        return view('players, $players);
    }
}
