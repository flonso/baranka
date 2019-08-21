<?php

namespace App\Exceptions;

class GameExceptions {
  public static function NoGamePhaseStarted() {
    return new NoGamePhaseStarted();
  }

  public static function GamePhaseAlreadyStarted() {
    return new GamePhaseAlreadyStarted();
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

class GamePhaseAlreadyStarted extends BaseException {
  function __construct() {
    parent::__construct(
      $message = "Une phase de jeu est déjà en cours.",
      $code = 9001
    );
  }
}
