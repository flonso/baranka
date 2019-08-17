<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception {
  public function toArray() {
    return [
      'error' => [
        'code' => $this->getCode(),
        'message' => $this->getMessage()
      ]
    ];
  }
}