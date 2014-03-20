<?php

namespace Altruja;

/**
 * A simple utility class to find the next workday from a date
 */

class Workday {

  public $date, $region, $strict;

  public function __construct(\DateTime $date, $region = 'Germany', $strict = true) {
    $this->date = clone $date;
    $this->region = $region;
    $this->strict = $strict;
  }

  public function next() {
    while ($this->isWeekend() || $this->isHoliday()) {
      $this->date->add(new \DateInterval("P1D"));
    }
    return $this->date;
  }

  public function isWeekend() {
    return $this->date->format('N') >= 6;
  }

  public function isHoliday() {
    $class = "\\Holiday\\$this->region";
    if (false == class_exists($class)) {
      throw new \Exception("Region \"$this->region\" not available, please write one");
    }
    $calc = new $class();
    $holidays = $calc->between($this->date, $this->date);
    $holiday = reset($holidays);
    $isHoliday = $holiday && ($holiday->type == \Holiday\HOLIDAY || ($this->strict == false && $holiday->type == \Holiday\NOTABLE));
    return $isHoliday;
  }

}

