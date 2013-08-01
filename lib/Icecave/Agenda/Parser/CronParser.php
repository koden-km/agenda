<?php
namespace Icecave\Agenda\Parser;

use Icecave\Agenda\Schedule\ScheduleInterface;
use Icecave\Agenda\Schedule\HourlySchedule;
use Icecave\Agenda\Schedule\DailySchedule;
use Icecave\Agenda\Schedule\WeeklySchedule;
use Icecave\Agenda\Schedule\MonthlySchedule;
use Icecave\Agenda\Schedule\YearlySchedule;
use Icecave\Agenda\TypeCheck\TypeCheck;
use InvalidArgumentException;

/**
 * @link https://en.wikipedia.org/wiki/Cron
 */
class CronParser implements ParserInterface
{
    const PREDEFINED_HOURLY   = '@hourly';
    const PREDEFINED_DAILY    = '@daily';
    const PREDEFINED_WEEKLY   = '@weekly';
    const PREDEFINED_MONTHLY  = '@monthly';
    const PREDEFINED_YEARLY   = '@yearly';
    const PREDEFINED_ANNUALLY = '@annually'; // Same as YEARLY

    const EXPRESSION_HOURLY   = '0 * * * *';
    const EXPRESSION_DAILY    = '0 0 * * *';
    const EXPRESSION_WEEKLY   = '0 0 * * 0';
    const EXPRESSION_MONTHLY  = '0 0 1 * *';
    const EXPRESSION_YEARLY   = '0 0 1 1 *';

    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
    }

    /**
     * @param string $expression
     *
     * @return ScheduleInterface
     * @throws InvalidArgumentException
     */
    public function parse($expression)
    {
        TypeCheck::get(__CLASS__)->parse(func_get_args());

        $schedule = null;
        if (!$this->tryParse($expression, $schedule)) {
            throw new InvalidArgumentException('Invalid cron expression: "' . $expression . '".');
        }

        return $schedule;
    }

    /**
     * @param string $expression
     * @param ScheduleInterface|null &$schedule The schedule to store the parsed result in.
     *
     * @return boolean True if the expression parsed successfully.
     */
    public function tryParse($expression, ScheduleInterface &$schedule = null)
    {
        TypeCheck::get(__CLASS__)->tryParse(func_get_args());

        if ($this->tryParsePredefinedFormat($expression, $schedule)) {
            return true;
        } else if ($this->tryParseExpressionFormat($expression, $schedule)) {
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
    public function tryParsePredefinedFormat($expression, ScheduleInterface &$schedule = null)
    {
        TypeCheck::get(__CLASS__)->tryParsePredefinedFormat(func_get_args());

        if ($expression === self::PREDEFINED_HOURLY) {
            $schedule = new HourlySchedule;
        } else if ($expression === self::PREDEFINED_DAILY) {
            $schedule = new DailySchedule;
        } else if ($expression === self::PREDEFINED_WEEKLY) {
            $schedule = new WeeklySchedule;
        } else if ($expression === self::PREDEFINED_MONTHLY) {
            $schedule = new MonthlySchedule;
        } else if ($expression === self::PREDEFINED_YEARLY || $expression === self::PREDEFINED_ANNUALLY) {
            $schedule = new YearlySchedule;
        } else {
            return false;
        }

        return true;
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#Predefined_scheduling_definitions
     *
     * @param string $expression
     * @param ScheduleInterface|null &$schedule
     *
     * @return boolean
     */
    public function tryParsePredefinedExpressionFormat($expression, ScheduleInterface &$schedule = null)
    {
        TypeCheck::get(__CLASS__)->tryParsePredefinedExpressionFormat(func_get_args());

        if ($expression === self::EXPRESSION_HOURLY) {
            $schedule = new HourlySchedule;
        } else if ($expression === self::EXPRESSION_DAILY) {
            $schedule = new DailySchedule;
        } else if ($expression === self::EXPRESSION_WEEKLY) {
            $schedule = new WeeklySchedule;
        } else if ($expression === self::EXPRESSION_MONTHLY) {
            $schedule = new MonthlySchedule;
        } else if ($expression === self::EXPRESSION_YEARLY) {
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
    public function tryParseExpressionFormat($expression, ScheduleInterface &$schedule = null)
    {
        TypeCheck::get(__CLASS__)->tryParseExpressionFormat(func_get_args());

        if ($this->tryParsePredefinedExpressionFormat($expression, $schedule)) {
            return true;
        }

        $parts = preg_split('/\s+/', $expression);
        if (count($parts) !== 5) {
            throw new InvalidArgumentException('Invalid cron expression: "' . $expression . '".');
        }

        list($expMinute, $expHour, $expDayOfMonth, $expMonth, $expDayOfWeek) = $parts;

        // TO DO: generic expression parsing

        return false;
    }

    private $typeCheck;
}
