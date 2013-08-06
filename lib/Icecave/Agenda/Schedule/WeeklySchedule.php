<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Agenda\TypeCheck\TypeCheck;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\Detail\Calendar;
use Icecave\Chrono\TimePointInterface;

/**
 * Run once a week at midnight in the morning of Sunday.
 */
class WeeklySchedule extends AbstractSchedule
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

        $dayOfWeek = $timePoint->isoDayOfWeek();

        if ($dayOfWeek === 7 &&
            $timePoint->hour() === 0 &&
            $timePoint->minute() === 0 &&
            $timePoint->second() === 0
        ) {
            return $timePoint;
        }

        // If Sunday but the time is past midnight, then go to next week.
        $daysUntilSunday = 7 - $dayOfWeek;
        if ($daysUntilSunday === 0) {
            if ($timePoint->hour() > 0 || $timePoint->minute() > 0 || $timePoint->second() > 0) {
                $daysUntilSunday = 7;
            }
        }

        return new DateTime(
            $timePoint->year(),
            $timePoint->month(),
            $timePoint->day() + $daysUntilSunday,
            0,
            0,
            0
        );
    }

    private $typeCheck;
}
