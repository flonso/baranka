<?php

namespace App\Models\Eloquent;

class EventType {
  private function __construct() {}

  const ITEM = 'item';
  const ITEM_FOUND = 'item_found';
  const BONUS = 'bonus';
  const MALUS = 'malus';
  const BOAT = 'boat';
  const MULTIPLIER = 'multiplier';
  const LEVEL_UP = 'level_up';
  const TREASURE = 'treasure';
}