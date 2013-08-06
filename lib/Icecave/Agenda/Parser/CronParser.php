<?php
namespace Icecave\Agenda\Parser;

use Icecave\Agenda\Schedule\ScheduleInterface;
use Icecave\Agenda\Schedule\HourlySchedule;
use Icecave\Agenda\Schedule\DailySchedule;
use Icecave\Agenda\Schedule\GenericSchedule;
use Icecave\Agenda\Schedule\MonthlySchedule;
use Icecave\Agenda\Schedule\WeeklySchedule;
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
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
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
            return false;
        }

        list($expMinute, $expHour, $expDayOfMonth, $expMonth, $expDayOfWeek) = $parts;
        $schedule = new GenericSchedule(
            $this,
            $expMinute,
            $expHour,
            $expDayOfMonth,
            $expMonth,
            $expDayOfWeek
        );

        return true;
    }




// https://en.wikipedia.org/wiki/Cron#Overview
// While normally the job is executed when the time/date specification fields all match the current time and date,
// there is one exception:
// if both "day of month" and "day of week" are restricted (not "*"),
// then either the "day of month" field (3) or the "day of week" field (5) must match the current day.

// https://en.wikipedia.org/wiki/Cron#CRON_expression
// Formats to support:
//      Field name      Mandatory?  Allowed values      Allowed special characters
//      Minutes         Yes         0-59                * / , -
//      Hours           Yes         0-23                * / , -
//      Day of month    Yes         1-31                * / , - ? L W
//      Month           Yes         1-12 or JAN-DEC     * / , -
//      Day of week     Yes         0-6 or SUN-SAT      * / , - ? L #
//      Year            No          1970–2099           * / , -



    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * @param integer|string $expMonth
     * @param TimePointInterface $timePoint
     *
     * @return integer The month offset for next schedule.
     */
    public function parseMonth($expMonth, TimePointInterface $timePoint) {
        if ($expMonth === '*') {
            return $timePoint->month();
        }

        // TO DO: parse month formats

        // Formats to support:
        //      Field name      Mandatory?  Allowed values      Allowed special characters
        //      Month           Yes         1-12 or JAN-DEC     * / , -


        if (strpos($expMonth, '/') !== false) {
            $parts = explode('/', $expMonth, 2);
            if ($parts[0] === '*') {
            }
        }


        throw new InvalidArgumentException('Invalid cron expression: "' . $expMonth . '".');
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * @param integer|string $expDayOfMonth
     * @param TimePointInterface $timePoint
     *
     * @return integer The day offset for next schedule.
     */
    public function parseDayOfMonth($expDayOfMonth, TimePointInterface $timePoint) {
        if ($expDayOfMonth === '*') {
            return $timePoint->day();
        }

        // TO DO: parse day formats

        // Formats to support:
        //      Field name      Mandatory?  Allowed values      Allowed special characters
        //      Day of month    Yes         1-31                * / , - ? L W

        throw new InvalidArgumentException('Invalid cron expression: "' . $expDayOfMonth . '".');
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * @param integer|string $expDayOfWeek
     * @param TimePointInterface $timePoint
     *
     * @return integer The day offset for next schedule.
     */
    public function parseDayOfWeek($expDayOfWeek, TimePointInterface $timePoint) {
        if ($expDayOfWeek === '*') {
            return $timePoint->day();
        }

        // TO DO: parse day formats

        // Formats to support:
        //      Field name      Mandatory?  Allowed values      Allowed special characters
        //      Day of week     Yes         0-6 or SUN-SAT      * / , - ? L #

        throw new InvalidArgumentException('Invalid cron expression: "' . $expDayOfWeek . '".');
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * @param integer|string $expDayOfMonth
     * @param integer|string $expDayOfWeek
     * @param TimePointInterface $timePoint
     *
     * @return integer The day offset for next schedule.
     */
    public function parseDay($expDayOfMonth, $expDayOfWeek, TimePointInterface $timePoint) {
        $dayOfMonthOffset = null;
        if ($expDayOfMonth !== '*') {
            $dayOfMonthOffset = $this->parser->parseDayOfMonth($expDayOfMonth, $timePoint);
        }

        $dayOfWeekOffset = null;
        if ($expDayOfWeek !== '*') {
            $dayOfWeekOffset = $this->parser->parseDayOfWeek($expDayOfWeek, $timePoint);
        }

        if ($dayOfMonthOffset === null && $dayOfWeekOffset === null) {
            return 0;
        } else if ($dayOfMonthOffset !== null && $dayOfWeekOffset === null) {
            return $dayOfMonthOffset;
        } else if ($dayOfMonthOffset === null && $dayOfWeekOffset !== null) {
            return $dayOfWeekOffset;
        }

        return min($dayOfMonthOffset, $dayOfWeekOffset);
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * @param integer|string $expHour
     * @param TimePointInterface $timePoint
     *
     * @return integer The hour offset for next schedule.
     */
    public function parseHour($expHour, TimePointInterface $timePoint) {
        if ($expHour === '*') {
            return $timePoint->hour();
        }

        // TO DO: parse hour formats

        // Formats to support:
        //      Field name      Mandatory?  Allowed values      Allowed special characters
        //      Hours           Yes         0-23                * / , -

        throw new InvalidArgumentException('Invalid cron expression: "' . $expHour . '".');
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * @param integer|string $expMinute
     * @param TimePointInterface $timePoint
     *
     * @return integer The minute offset for next schedule.
     */
    public function parseMinute($expMinute, TimePointInterface $timePoint) {
        if ($expMinute === '*') {
            return $timePoint->minute();
        }

        // TO DO: parse minute formats

        // Formats to support:
        //      Field name      Mandatory?  Allowed values      Allowed special characters
        //      Minutes         Yes         0-59                * / , -

        throw new InvalidArgumentException('Invalid cron expression: "' . $expMinute . '".');
    }

    private $typeCheck;
}
