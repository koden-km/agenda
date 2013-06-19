<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimePointInterface;

/**
 * Run once a day at midnight.
 */
class DailySchedule extends AbstractSchedule
{
    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface|null The next scheduled time point.
     */
    public function firstEventFrom(TimePointInterface $timePoint)
    {
        if ($timePoint->hour() === 0 &&
            $timePoint->minute() === 0 &&
            $timePoint->second() === 0
        ) {
            return $timePoint;
        }

        return new DateTime(
            $timePoint->year(),
            $timePoint->month(),
            $timePoint->day() + 1,
            0,
            0,
            0
        );
    }
}
