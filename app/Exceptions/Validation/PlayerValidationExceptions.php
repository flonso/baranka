<?php

namespace App\Exceptions\Validation;

use App\Exceptions\BaseException;

class PlayerValidationExceptions {
  public static function MissingRequiredField(string $fieldName) {
    return new MissingRequiredField($fieldName);
  }
}

class MissingRequiredField extends BaseException {
  function __construct(string $fieldName) {
    parent::__construct(
      $message = "Le champ '$fieldName' du joueur est manquant.",
      $code = 1100
    );
  }
}
