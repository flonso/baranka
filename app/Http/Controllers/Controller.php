<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiExceptions;
use App\Exceptions\BaseException;
use App\Exceptions\GameExceptions;
use App\Models\Eloquent\BaseModel;
use App\Models\Eloquent\Event;
use App\Models\Eloquent\GamePhase;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function rollbackAndRespondWithException(BaseException $e, int $status = 400) {
        DB::rollBack();
        return $e->toResponse($status);
    }

    public function commitAndRespondWithModel(BaseModel $model) {
        DB::commit();

        return response()->json($model);
    }

    /**
     * Persists all given changes within a database transaction.
     * Builds a response which can be returned directly in the controller.
     *
     *
     * @param array $models The models to persist transactionally
     * @param BaseModel|null $toReturn The model to JSON encode in case of success
     * @return JsonResponse
     */
    public function persistModels(array $models, BaseModel $toReturn = null) {
        if (count($models) == 0) {
            return response()->json(
                $toReturn,
                (isset($toReturn)) ? 200 : 204 // 204 = No content
            );
        }

        DB::beginTransaction();
        try {
            $allSaved = true;
            $gamePhase = GamePhase::current();

            foreach ($models as $model) {
                if ($model instanceof Event) {
                    if (isset($gamePhase)) {
                        $model->gamePhase()->associate($gamePhase);
                    } else {
                        return $this->rollbackAndRespondWithException(
                            GameExceptions::NoGamePhaseStarted(),
                            400
                        );
                    }
                }

                $allSaved = $allSaved && $model->save();
            }

            if ($allSaved) {
                return $this->commitAndRespondWithModel($toReturn);
            }

            throw ApiExceptions::CouldNotSaveData();
        } catch (\Exception $e) {
            return $this->rollbackAndRespondWithException(
                ApiExceptions::GenericException($e),
                500
            );
        }
    }
}
