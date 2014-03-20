Workday
=======

A simple tool to find the next work day.

Usage:

    $dayToCheck = new DateTime();

    $workday = new \Altruja\Workday($dayToCheck);
    $workday->next();

    $nextWorkDay = $workday->date;

Different region (Germany is default)

    $workday = new \Altruja\Workday($dayToCheck, 'Bavaria');

Include legal workdays commonly considered holidays

    $workday = new \Altruja\Workday($dayToCheck, 'Bavaria', false);

Three workdays after the next workday

    $workday = new \Altruja\Workday($dayToCheck);

    $workday->next(3);

    $thirdWorkDay = $workday->date;

Note: If the supplied day already is a work day, that day is considered the next work day.

