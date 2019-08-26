<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiExceptions;
use App\Exceptions\GameExceptions;
use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Common\PaginationParameters;
use App\Models\Eloquent\GamePhase;
use App\Models\Eloquent\Item;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of all items.
     *
     * @param Request $request The resquest
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {
        $params = new PaginationParameters(
            intval($request->input('page'))
        );

        $query = DB::table('items')
            ->offset($params->offset)
            ->limit($params->limit)
        ;

        return response()->json([
            'data' => $query->get(),
            'count' => Item::count()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateItemRequest $create) {
        $item = new Item();
        $item->name = $create->name;
        $item->certificate_number = $create->certificateNumber;
        $item->discovery_points = $create->discoveryPoints;
        $item->adventure_points = $create->adventurePoints;
        $item->multiplier_increment = $create->multiplierIncrement ?? 0;

        $saved = $item->save();

        if ($saved) {
            return response()->json($item);
        }

        return response()->json(
            ApiExceptions::CouldNotSaveData()->toArray(),
            500
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UpdateItemRequest  $update
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $update, Item $item) {
        $events = $item->updateFromData($update);

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

        if ($item->save()) {
            return response()->json($item);
        }

        return response()->json(
            ApiExceptions::CouldNotSaveData()->toArray(),
            500
        );
    }
}
