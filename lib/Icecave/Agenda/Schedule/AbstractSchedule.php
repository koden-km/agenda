<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Agenda\TypeCheck\TypeCheck;
use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\TimePointInterface;

abstract class AbstractSchedule implements ScheduleInterface
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
    }

    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface|null The next scheduled time point.
     */
    public function firstEventAfter(TimePointInterface $timePoint)
    {
        TypeCheck::get(__CLASS__)->firstEventAfter(func_get_args());

        return $this->firstEventFrom($timePoint->add(1));
    }

    /**
     * @param IntervalInterface $interval
     *
     * @return TimePointInterface|null The next scheduled time point.
     */
    public function firstEventDuring(IntervalInterface $interval)
    {
        TypeCheck::get(__CLASS__)->firstEventDuring(func_get_args());

        $timePoint = $this->firstEventFrom($interval->start());
        if ($interval->contains($timePoint)) {
            return $timePoint;
        }

        return null;
    }

    private $typeCheck;
}
