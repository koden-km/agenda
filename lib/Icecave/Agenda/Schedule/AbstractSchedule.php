<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\TimePointInterface;

abstract class AbstractSchedule implements ScheduleInterface
{
    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface|null The next scheduled time point.
     */
    public function firstEventAfter(TimePointInterface $timePoint)
    {
        return $this->firstEventFrom($timePoint->add(1));
    }

    /**
     * @param IntervalInterface $interval
     *
     * @return TimePointInterface|null The next scheduled time point.
     */
    public function firstEventDuring(IntervalInterface $interval)
    {
        $timePoint = $this->firstEventFrom($interval->start());
        if ($interval->contains($timePoint)) {
            return $timePoint;
        }

        return null;
    }
}
