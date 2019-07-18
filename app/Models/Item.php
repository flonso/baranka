<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The item's name.
     *
     * @var string
     */
    public $name;

    /**
     * The item's certificate number.
     *
     * @var string
     */
    public $certificate_number;

    /**
     * The amount of points gained by discovering this item.
     *
     * @var int
     */
    public $discovery_points;

    /**
     * The amount of points gained by accomplishing the adventure
     * related to this object.
     *
     * @var int
     */
    public $adventure_points;

    /**
     * The amount by which a team's score multiplier can be increased
     * after discovering this item.
     *
     * @var double
     */
    public $multiplier_increment;

    /**
     * Whether this item has already been discovered.
     *
     * @var boolean
     */
    public $discovered;

    public function discoveredBy(): Player {
        return $this->hasOne('App\Models\Player', 'discovered_by_id');
    }
}
