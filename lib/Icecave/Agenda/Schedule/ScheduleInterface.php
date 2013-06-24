<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\TimePointInterface;

interface ScheduleInterface
{
    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface|null The next scheduled time point.
     */
    public function firstEventFrom(TimePointInterface $timePoint);

    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface|null The next scheduled time point.
     */
    public function firstEventAfter(TimePointInterface $timePoint);

    /**
     * @param IntervalInterface $interval
     *
     * @return TimePointInterface|null The next scheduled time point.
     */
    public function firstEventDuring(IntervalInterface $interval);
}
