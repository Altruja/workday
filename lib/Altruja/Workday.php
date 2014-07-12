<?php

namespace Altruja;

/**
 * A simple utility class to find the next workday from a date
 */

class Workday {

  public $date, $region, $strict;

  public function __construct(\DateTime $date, $region = 'Germany', $strict = true) {
    $this->date = $date;
    $this->region = $region;
    $this->strict = $strict;
    $class = "\\Holiday\\$this->region";
    if (false == class_exists($class)) {
      throw new \Exception("Region \"$this->region\" not available, please write one");
    }
    $this->holiday = new $class();
  }

  public function next($num = null)
  {
    $this->step('+1 day', $num);
  }

  public function previous($num = null)
  {
    $this->step('-1 day', $num);
  }

  private function step($direction, $num = null)
  {
    // Move to next/previous workday, or present day if already is workday
    while ($this->isWeekend() || $this->isHoliday()) {
      $this->date->modify($direction);
    }

    // Add a number of days if applicable, always moving to the next/previous work day
    // In effect this adds a number of business days
    if ($num !== null) {
      for ($i = 0; $i < $num; $i++) {
        $this->date->modify($direction);
        $this->step($direction);
      }
    }
    return $this->date;
  }

  public function isWeekend() {
    return $this->date->format('N') >= 6;
  }

  public function isHoliday() {
    $holidays = $this->holiday->between($this->date, $this->date);
    $holiday = reset($holidays);
    $isHoliday = $holiday && ($holiday->type == \Holiday\HOLIDAY || ($this->strict == false && $holiday->type == \Holiday\NOTABLE));
    return $isHoliday;
  }

}

