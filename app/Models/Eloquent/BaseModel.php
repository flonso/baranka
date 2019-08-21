<?php

namespace App\Models\Eloquent;

use App\Exceptions\ApiExceptions;
use App\Http\Requests\UpdatePlayerRequest;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model {
    // Based on https://stackoverflow.com/questions/25660964/port-stdclass-data-to-model
    /**
     * Converts a stdClass instance to the given model instance. Use this method when
     * desiring to cast an instance retrieved through Laravel's query builder.
     *
     * @param \stdClass $obj
     * @param Model $targetModel
     * @return void
     */
    public static function toInstance(\stdClass $obj, Model $targetModel) {
        $backupFillable = $targetModel->getFillable();

        // FIXME: This might be unsafe if we customized column names...
        $columns = $targetModel->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing(
                $targetModel->getTable()
            );


        $targetModel->fillable($columns);
        $targetModel->fill((array) $obj);
        $targetModel->syncOriginal();
        $targetModel->exists = true;

        $targetModel->fillable($backupFillable);

        return $targetModel;
    }

    abstract public static function count();

    /**
     * Retrieve the model for a bound value. Will return a JSON
     * response in case it is not found.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value) {
        $fetched = $this->where('id', $value)->first();

        if ($fetched == null) {
            $name = (new \ReflectionClass($this))->getShortName();
            abort(
                response()->json(
                    ApiExceptions::ModelNotFound($name, $value)->toArray(),
                    404
                )
            );
        }

        return $fetched;
    }
}