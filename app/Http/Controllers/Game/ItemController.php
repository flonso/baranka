<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiExceptions;
use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Common\PaginationParameters;
use App\Models\Eloquent\EventType;
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
        $query = $request->input('query');

        $withMultiplier = $request->input('withMultiplier', null);
        $withMultiplier = isset($withMultiplier) ? filter_var($withMultiplier, FILTER_VALIDATE_BOOLEAN) : null;

        $adventureCompleted = $request->input('adventureCompleted', null);
        $adventureCompleted = isset($adventureCompleted) ? filter_var($adventureCompleted, FILTER_VALIDATE_BOOLEAN) : null;

        $discovered = $request->input('discovered', null);
        $discovered = isset($discovered) ? filter_var($discovered, FILTER_VALIDATE_BOOLEAN) : null;

        $params = new PaginationParameters(
            intval($request->input('page')),
            intval($request->input('limit'))
        );

        // The base requests
        $items = Item::offset($params->offset)
            ->limit($params->limit);
        $countQuery = Item::with('discoveredByPlayers')
        ->with('adventureCompletedByPlayers')
        ;

        // Filter based on parameters
        if (isset($query)) {
            $items->where('name', 'like', "%$query%");
            $countQuery->where('name', 'like', "%$query%");
        }

        if (isset($withMultiplier)) {
            if ($withMultiplier === true) {
                $items = $items->where('multiplier_increment', '!=', '0');
                $countQuery = $countQuery->where('multiplier_increment', '!=', '0');
            } else {
                $items = $items->where('multiplier_increment', '=', '0');
                $countQuery = $countQuery->where('multiplier_increment', '=', '0');
            }
        }

        if (isset($discovered)) {
            if ($discovered === true) {
                $items = $items->has('discoveredByPlayers')
                    ->with('discoveredByPlayers');
                $countQuery = $countQuery->has('discoveredByPlayers');
            } else {
                $items = $items->doesntHave('discoveredByPlayers');
                $countQuery = $countQuery->doesntHave('discoveredByPlayers');
            }
        }

        if (isset($adventureCompleted)) {
            if ($adventureCompleted === true) {
                $items = $items->has('adventureCompletedByPlayers')
                    ->with('adventureCompletedByPlayers');
                $countQuery = $countQuery->has('adventureCompletedByPlayers');
            } else {
                $items = $items->doesntHave('adventureCompletedByPlayers');
                $countQuery = $countQuery->doesntHave('adventureCompletedByPlayers');
            }
        }

        return response()->json([
            'data' => $items->get(),
            'count' => $countQuery->count()
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
        $item->discoverable_from_phase = $create->discoverableFromPhase;
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
     * Update the specified item.
     *
     * @param  UpdateItemRequest  $update
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $update, Item $item) {
        $alreadyDiscovered = $item->discovered;
        $events = $item->updateFromData($update);
        $models = [$item];

        // If item already discovered, we don't re-apply the score multiplier
        $multiplier_incremented = $alreadyDiscovered;

        // FIXME: If the same player is referenced in two different events, only the second update
        // will get applied. (Use a map from model-type-id to the already updated model to stack updates)
        $team = null;
        foreach ($events as $event) {
            switch ($event->type) {
                case EventType::ITEM:
                    $team = $team ?? $event->team;
                    $player = $event->player;

                    // Assuming that item value was split in multiple events (one per player)
                    $player->score += $event->value;
                    $team->score += $event->value;

                    // Only increment multiplier once, as this is not shared between players
                    if (!$multiplier_incremented) {
                        $team->score_multiplier += $item->multiplier_increment;
                        $multiplier_incremented = true;
                    }

                    $models[] = $player;
                    $models[] = $team;
                default:
                    // Ignore
            }
        }

        return $this->persistModels(
            array_merge($events, $models),
            $item
        );
    }
}
