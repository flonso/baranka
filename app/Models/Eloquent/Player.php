<?php

namespace App\Models\Eloquent;

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

    public static function count() {
        return DB::table('players')->count();
    }
}
