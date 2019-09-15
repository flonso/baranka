<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiExceptions;
use App\Exceptions\GameExceptions;
use App\Http\Requests\StartGameRequest;
use App\Models\Eloquent\GamePhase;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Facades\Request;

class GameController extends Controller {
    /**
     * Return the current game phase if any. 404 otherwise.
     */
    public function status(Request $request) {
        $current = GamePhase::last();

        if ($current) {
            return response()->json($current);
        }

        return GameExceptions::NoGamePhaseStarted()->toResponse(404);
    }

    public function start(StartGameRequest $start) {
        // FIXME: Make sure no race conditions can occur (one client starting in parallel to another)
        $lastPhase = GamePhase::last();

        $phaseStarted = $lastPhase != null && $lastPhase->end_datetime == null;
        if ($phaseStarted) {
            return response()->json(
                GameExceptions::GamePhaseAlreadyStarted()->toArray(),
                500
            );
        }

        $newPhase = new GamePhase();
        $newPhase->start_datetime = Carbon::now(
            new DateTimeZone('Europe/Paris')
        )->toDateTimeString();

        if (isset($start->number)) {
            $newPhase->number = $start->number;
        } else {
            $newPhase->number = ($lastPhase != null) ? $lastPhase->number + 1 : 1;
        }

        if ($newPhase->save()) {
            return response()->json($newPhase);
        } else {
            return response()->json(
                ApiExceptions::CouldNotSaveData()->toArray(),
                500
            );
        }
    }

    public function stop(Request $request) {
        $currentPhase = GamePhase::current();

        if ($currentPhase != null) {
            $currentPhase->end_datetime = Carbon::now(
                new DateTimeZone('Europe/Paris')
            )->toDateTimeString();

            if ($currentPhase->save()) {
                return response()->json($currentPhase);
            } else {
                response()->json(
                    ApiExceptions::CouldNotSaveData(),
                    500
                );
            }
        }

        return response()->json(
            GameExceptions::NoGamePhaseStarted()->toArray(),
            500
        );
    }

    public function clans() {
        return response()->json([
            "data" => [
                [
                    "name" => "Sept Mers",
                    "points" => 232
                ],
                [
                    "name" => "Tricornes des Sables",
                    "points" => 210
                ],
                [
                    "name" => "Flibustiers du Cap",
                    "points" => 103
                ],
                [
                    "name" => "Crânes Rouges",
                    "points" => 90
                ],
                [
                    "name" => "Requins Noirs",
                    "points" => 88
                ],
                [
                    "name" => "Oeil du Singe",
                    "points" => 0
                ]
            ]
        ]);
    }
}