<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Chrono\IntervalInterface;
use Icecave\Chrono\TimePointInterface;

class HourlySchedule implements ScheduleInterface
{
    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface The next scheduled time point.
     */
    public function firstEventFrom(TimePointInterface $timePoint)
    {
        return $this->calculateNextDateTime($timePoint);
    }

    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface The next scheduled time point.
     */
    public function firstEventAfter(TimePointInterface $timePoint)
    {
        return $this->calculateNextDateTime($timePoint->add(new Duration(1)));
    }

    /**
     * @param IntervalInterface $interval
     *
     * @return TimePointInterface The next scheduled time point.
     */
    public function firstEventDuring(IntervalInterface $interval)
    {
        return $this->firstEventOnOrAfter($interval->start());
    }

    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface The next scheduled datetime.
     */
    protected function calculateNextDateTime(TimePointInterface $timePoint)
    {
    }
}
