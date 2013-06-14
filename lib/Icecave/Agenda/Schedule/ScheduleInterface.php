<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Chrono\IntervalInterface;
use Icecave\Chrono\TimePointInterface;

interface ScheduleInterface
{
    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface The next scheduled time point.
     */
    public function firstEventFrom(TimePointInterface $timePoint);

    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface The next scheduled time point.
     */
    public function firstEventAfter(TimePointInterface $timePoint);

    /**
     * @param IntervalInterface $interval
     *
     * @return TimePointInterface The next scheduled time point.
     */
    public function firstEventDuring(IntervalInterface $interval);
}
