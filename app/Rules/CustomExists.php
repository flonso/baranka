<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CustomExists implements Rule
{
    private $callback;
    private $table;
    private $value;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, \Closure $callback)
    {
        $this->table = $table;
        $this->callback = $callback;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->value = $value;
        $query = DB::table($this->table);
        $this->callback->call(
            $this,
            $query,
            $value
        );

        return $query->count() > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Il n'existe pas de $this->table correspondant à la valeur '$this->value'";
    }
}
