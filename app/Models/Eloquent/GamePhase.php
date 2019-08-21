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
        $obj = DB::table('game_phases')
            ->whereNull('end_datetime')
            ->orderBy('start_datetime')
            ->first();

        if ($obj == null) return null;

        return self::toInstance(
            $obj,
            new GamePhase()
        );
    }

    public static function last() {
        $obj = DB::table('game_phases')
            ->orderBy('start_datetime')
            ->first();

        if ($obj == null) return null;

        return self::toInstance(
            $obj,
            new GamePhase()
        );
    }

    public static function count() {
        return DB::table('game_phases')->count();
    }
}
