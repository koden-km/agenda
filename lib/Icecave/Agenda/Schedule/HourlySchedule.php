<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimePointInterface;

/**
 * Run once an hour at the beginning of the hour.
 */
class HourlySchedule extends AbstractSchedule
{
    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface|null The next scheduled time point.
     */
    public function firstEventFrom(TimePointInterface $timePoint)
    {
        if ($timePoint->minute() === 0 &&
            $timePoint->second() === 0
        ) {
            return $timePoint;
        }

        return new DateTime(
            $timePoint->year(),
            $timePoint->month(),
            $timePoint->day(),
            $timePoint->hour() + 1,
            0,
            0
        );
    }
}
