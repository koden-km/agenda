<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Agenda\TypeCheck\TypeCheck;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimePointInterface;

/**
 * Run once a day at midnight.
 */
class DailySchedule extends AbstractSchedule
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
        parent::__construct();
    }

    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface|null The next scheduled time point.
     */
    public function firstEventFrom(TimePointInterface $timePoint)
    {
        TypeCheck::get(__CLASS__)->firstEventFrom(func_get_args());

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

    private $typeCheck;
}
