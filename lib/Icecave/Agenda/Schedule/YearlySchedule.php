<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimePointInterface;

/**
 * Run once a year at midnight in the morning of January 1.
 */
class YearlySchedule extends AbstractSchedule
{
    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface|null The next scheduled time point.
     */
    public function firstEventFrom(TimePointInterface $timePoint)
    {
        if ($timePoint->month() === 1 &&
            $timePoint->day() === 1 &&
            $timePoint->hour() === 0 &&
            $timePoint->minute() === 0 &&
            $timePoint->second() === 0
        ) {
            return $timePoint;
        }

        return new DateTime(
            $timePoint->year() + 1,
            1,
            1,
            0,
            0,
            0
        );
    }
}
