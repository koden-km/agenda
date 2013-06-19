<?php
namespace Icecave\Agenda\Parser;

use Icecave\Agenda\Schedule\HourlySchedule;
use Icecave\Agenda\Schedule\DailySchedule;
use Icecave\Agenda\Schedule\WeeklySchedule;
use Icecave\Agenda\Schedule\MonthlySchedule;
use Icecave\Agenda\Schedule\YearlySchedule;
use InvalidArgumentException;

/**
 * @link https://en.wikipedia.org/wiki/Cron
 */
class CronParser implements ParserInterface
{
    public function __construct()
    {
    }

    /**
     * @param string $expression
     *
     * @return ScheduleInterface
     * @throws InvalidArgumentException
     */
    public function parse($expression)
    {
        $schedule = null;
        if (!$this->tryParse($expression, $schedule)) {
            throw new InvalidArgumentException('Invalid cron expression: "' . $expression . '".');
        }

        return $schedule;
    }

    /**
     * @param string $expression
     * @param ScheduleInterface &$schedule = null The schedule to store the parsed result in.
     *
     * @return boolean True if the expression parsed successfully.
     */
    public function tryParse($expression, ScheduleInterface &$schedule = null)
    {
        if ($this->tryParseConstantFormat($expression, $schedule)) {
            return true;
        } else if ($this->tryParseColumnFormat($expression, $schedule)) {
            return true;
        }

        return false;
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#Predefined_scheduling_definitions
     *
     * @param string $expression
     * @param ScheduleInterface|null &$schedule
     *
     * @return boolean
     */
    public function tryParseConstantFormat($expression, ScheduleInterface &$schedule = null)
    {
        if (in_array($expression, array('@hourly', '0 * * * *'))) {
            $schedule = new HourlySchedule;
        } else if (in_array($expression, array('@daily', '0 0 * * *'))) {
            $schedule = new DailySchedule;
        } else if (in_array($expression, array('@weekly', '0 0 * * 0'))) {
            $schedule = new WeeklySchedule;
        } else if (in_array($expression, array('@monthly', '0 0 1 * *'))) {
            $schedule = new MonthlySchedule;
        } else if (in_array($expression, array('@yearly', '@annually', '0 0 1 1 *'))) {
            $schedule = new YearlySchedule;
        } else {
            return false;
        }

        return true;
    }

    /**
     * @param string $expression
     * @param ScheduleInterface|null &$schedule
     *
     * @return boolean
     */
    public function tryParseColumnFormat($expression, ScheduleInterface &$schedule = null)
    {
        // TO DO

        return false;
    }
}
