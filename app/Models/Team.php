<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Team extends Model
{
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The name of the team.
     *
     * @var string
     */
    public $name;

    /**
     * The team's score.
     * @var int
     */
    public $score;

    /**
     * The multiplier applied to the team's score.
     *
     * @var double
     */
    public $score_multiplier;

    /**
     * The members of the team.
     */
    public function players(): Collection {
        return $this->hasMany('App/Models/Player');
    }
}
