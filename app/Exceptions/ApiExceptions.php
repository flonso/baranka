<?php

namespace App\Exceptions;

class ApiExceptions {
  public static function CouldNotSaveData() {
    return new CouldNotSaveData();
  }

  public static function InvalidData(array $errors) {
    return new InvalidData($errors);
  }

  public static function ModelNotFound(string $modelName, $value) {
    return new ModelNotFound($modelName, $value);
  }
}

class CouldNotSaveData extends BaseException {
  function __construct() {
    parent::__construct(
      $message = "La sauvegarde des données a rencontré une erreur inattendue.",
      $code = 9100
    );
  }
}

class InvalidData extends BaseException {
  private $errors = null;

  function __construct(array $errors) {
    $this->errors = $errors;
    parent::__construct(
      $message = "Des données invalides ont été envoyées.",
      $code = 9101
    );
  }

  public function getErrors()
  {
    return $this->errors;
  }
}

class ModelNotFound extends BaseException {
  function __construct(string $modelName, $value) {
    parent::__construct(
      $message = "Aucun objet de type $modelName trouvé pour l'id '$value'",
      $code = 9102
    );
  }
}