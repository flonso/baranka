<?php

namespace App\Models\Eloquent;

use Illuminate\Support\Facades\DB;

class GamePhase extends BaseModel
{
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'number', 'start_datetime', 'end_datetime'
    ];

    public function events() {
        return $this->hasMany('App\Models\Eloquent\Event');
    }

    public static function current() {
        return DB::table('game_phases')
            ->whereNull('end_datetime')
            ->orderBy('start_datetime')
            ->first();
    }
}
