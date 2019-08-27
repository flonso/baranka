<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiExceptions;
use App\Exceptions\BaseException;
use App\Exceptions\GameExceptions;
use App\Models\Eloquent\BaseModel;
use App\Models\Eloquent\GamePhase;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function rollbackWithExceptionResponse(BaseException $e, int $status = 400) {
        DB::rollBack();
        return $e->toResponse($status);
    }

    public function commitWithModel(BaseModel $model) {
        DB::commit();

        return response()->json($model);
    }

    public function persistEventsWithModel(BaseModel $model, array $events) {
        DB::beginTransaction();
        try {
            $allSaved = true;
            if (is_array($events) && count($events) > 0) {
                if ($gamePhase = GamePhase::current()) {
                    foreach ($events as $e) {
                        $e->gamePhase()->associate($gamePhase);
                        $allSaved = $allSaved && $e->save();
                    }
                } else {
                    return $this->rollbackWithExceptionResponse(
                        GameExceptions::NoGamePhaseStarted(),
                        400
                    );
                }
            }

            $allSaved = $allSaved && $model->save();
            if ($allSaved) {
                return $this->commitWithModel($model);
            }

            throw ApiExceptions::CouldNotSaveData();
        } catch (\Exception $e) {
            return $this->rollbackWithExceptionResponse(
                ApiExceptions::GenericException($e),
                500
            );
        }
    }
}
