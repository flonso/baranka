<?php

namespace App\Models\Eloquent;

use App\Exceptions\Validation\PlayerValidationExceptions;
use Illuminate\Support\Facades\DB;

class Player extends BaseModel
{
    public $incrementing = true;
    public $timestamps = true;

    protected $attributes = [
        'level' => 1,
        'score' => 0,
    ];

    public function discoveredItems() {
        return $this->hasMany('App\Models\Item', 'discovered_by_id');
    }

    public function team() {
        return $this->belongsTo('App\Models\Team');
    }

    /**
     * The events that this player has induced.
     */
    public function events() {
        return $this->belongsTo('App\Models\Eloquent\Event');
    }

    /**
     * Checks whether the given data is valid for a player creation.
     *
     * @param array $data
     * @return array The array of validated data if everything went fine
     */
    public static function isCreateValid(array $data) {
        $validatedData = [];

        if (isset($data['code']) && $code = $data['code']) {
            $validatedData['code'] = $code;
        } else {
            throw PlayerValidationExceptions::MissingRequiredField("code");
        }

        if (isset($data['firstName']) && $firstName = $data['firstName']) {
            if (length(trim($firstName)) == 0) {

            }
        } else {
            throw PlayerValidationExceptions::MissingRequiredField("firstName");
        }

        return $validatedData;
    }

    public static function count() {
        return DB::table('players')->count();
    }
}
