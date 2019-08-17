<?php

namespace App\Exceptions;

class GameExceptions {
  public static function NoGamePhaseStarted() {
    return new NoGamePhaseStarted();
  }
}

class NoGamePhaseStarted extends BaseException {
  function __construct() {
    parent::__construct(
      $message = "Aucune phase de jeu n'est actuellement en cours.",
      $code = 9000
    );
  }
}