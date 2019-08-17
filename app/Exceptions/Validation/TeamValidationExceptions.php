<?php

namespace App\Exceptions\Validation;

use App\Exceptions\BaseException;

class TeamValidationExceptions {
  public static function InvalidScoreIncrement($value) {
    return new InvalidScoreIncrement($value);
  }

  public static function InvalidScoreMultiplierIncrement($value) {
    return new InvalidScoreMultiplierIncrement($value);
  }
}

class InvalidScoreIncrement extends BaseException {
  function __construct($value) {
    parent::__construct(
      $message = "'$value' n'est pas un nombre entier valide pour modifier le score.",
      $code = 1000
    );
  }
}


class InvalidScoreMultiplierIncrement extends BaseException {
  function __construct($value) {
    parent::__construct(
      $message = "'$value' n'est pas un nombre décimal valide pour modifier le multiplicateur de score.",
      $code = 1001
    );
  }
}

