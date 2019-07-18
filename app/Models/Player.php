<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $incrementing = true;
    public $timestamps = true;


    /**
     * A custom player identifier, this number must be unique.
     *
     * @var int
     */
    public $number;

    /**
     * The player's first name.
     *
     * @var string
     */
    public $first_name;

    /**
     * The player's last name.
     *
     * @var string
     */
    public $last_name;

    /**
     * The player's level in the game.
     *
     * @var int
     */
    public $level;

    /**
     * The player's individual score in the game.
     *
     * @var int
     */
    public $score;

    public function team(): Team {
        return $this->belongsTo('App\Models\Team');
    }
}
