<?php

namespace App\Models\Eloquent;

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

        // FIXME: This might be unsafe ?
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
}