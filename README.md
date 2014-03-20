Workday
=======

A simple tool to find the next work day.

Usage:

    $dayToCheck = new DateTime();

    $workday = new \Altruja\Workday($dayToCheck);

    $nextWorkDay = $workday->next();

Different region (Germany is default)

    $workday = new \Altruja\Workday($dayToCheck, 'Bavaria');

Include legal workdays commonly considered holidays

    $workday = new \Altruja\Workday($dayToCheck, 'Bavaria', false);


