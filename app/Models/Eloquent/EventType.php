<?php

namespace App\Models\Eloquent;

class EventType {
  private function __construct() {}
  
  //4 basic categories
  const BOARD = 'board';
  const ITEM = 'item'; 
  const QUEST = 'quest';
  const LEVEL_CHANGE = 'level_change';
  
  //bonus or malus prestige points (including treasure bonus)
  const MANUAL_POINTS = 'manual_points';

  //number of boat parts, used to calculate final multiplier
  const BOAT = 'boat';
  
}