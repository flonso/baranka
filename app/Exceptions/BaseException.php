<?php

namespace App\Exceptions;

use Exception;

abstract class BaseException extends Exception {
  /**
   * Gets an optional array of additional errors
   *
   * @return array|null
   */
  function getErrors() {
    return null;
  }

  public function toArray() {
    $arr = [
      'message' => $this->getMessage(),
      'code' => $this->getCode()
    ];

    $errors = $this->getErrors();
    if ($errors != null) {
      $arr['errors'] = $errors;
    }

    return $arr;
  }
}