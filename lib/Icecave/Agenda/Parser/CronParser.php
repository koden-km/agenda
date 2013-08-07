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
use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimePointInterface;
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
     * @param string $expression The cron expression to parse.
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
     * @param string                 $expression The cron expression to parse.
     * @param ScheduleInterface|null &$schedule  The schedule to store the parsed result in.
     *
     * @return boolean True if the expression parsed successfully.
     */
    public function tryParse($expression, ScheduleInterface &$schedule = null)
    {
        TypeCheck::get(__CLASS__)->tryParse(func_get_args());

        if ($this->tryParsePredefinedFormat($expression, $schedule)) {
            return true;
        } elseif ($this->tryParseExpressionFormat($expression, $schedule)) {
            return true;
        }

        return false;
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#Predefined_scheduling_definitions
     *
     * @param string                 $expression The cron expression to parse.
     * @param ScheduleInterface|null &$schedule  The schedule to store the parsed result in.
     *
     * @return boolean
     */
    public function tryParsePredefinedFormat($expression, ScheduleInterface &$schedule = null)
    {
        TypeCheck::get(__CLASS__)->tryParsePredefinedFormat(func_get_args());

        if ($expression === self::PREDEFINED_HOURLY) {
            $schedule = new HourlySchedule;
        } elseif ($expression === self::PREDEFINED_DAILY) {
            $schedule = new DailySchedule;
        } elseif ($expression === self::PREDEFINED_WEEKLY) {
            $schedule = new WeeklySchedule;
        } elseif ($expression === self::PREDEFINED_MONTHLY) {
            $schedule = new MonthlySchedule;
        } elseif ($expression === self::PREDEFINED_YEARLY || $expression === self::PREDEFINED_ANNUALLY) {
            $schedule = new YearlySchedule;
        } else {
            return false;
        }

        return true;
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#Predefined_scheduling_definitions
     *
     * @param string                 $expression The cron expression to parse.
     * @param ScheduleInterface|null &$schedule  The schedule to store the parsed result in.
     *
     * @return boolean
     */
    public function tryParsePredefinedExpressionFormat($expression, ScheduleInterface &$schedule = null)
    {
        TypeCheck::get(__CLASS__)->tryParsePredefinedExpressionFormat(func_get_args());

        if ($expression === self::EXPRESSION_HOURLY) {
            $schedule = new HourlySchedule;
        } elseif ($expression === self::EXPRESSION_DAILY) {
            $schedule = new DailySchedule;
        } elseif ($expression === self::EXPRESSION_WEEKLY) {
            $schedule = new WeeklySchedule;
        } elseif ($expression === self::EXPRESSION_MONTHLY) {
            $schedule = new MonthlySchedule;
        } elseif ($expression === self::EXPRESSION_YEARLY) {
            $schedule = new YearlySchedule;
        } else {
            return false;
        }

        return true;
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * @param string                 $expression The cron expression to parse.
     * @param ScheduleInterface|null &$schedule  The schedule to store the parsed result in.
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

        // Resolve against a time point to verify.
        $schedule->firstEventFrom(new DateTime(2010, 1, 1));

        return true;
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * @param integer|string     $expMonth  The month part of the cron expression.
     * @param TimePointInterface $timePoint The timepoint to resolve against.
     *
     * @return integer                  The month offset from timepoint for next schedule.
     * @throws InvalidArgumentException
     */
    public function parseMonthExpression($expMonth, TimePointInterface $timePoint)
    {
        TypeCheck::get(__CLASS__)->parseMonthExpression(func_get_args());

        if ($expMonth === '*') {
            return 0;
        }

        $value = $this->parseIntegerExpression($expMonth, 1, 12, $timePoint->month());
        if ($value !== null) {
            return $value;
        }

        $value = $this->parseMonthNameExpression($expMonth, $timePoint->month());
        if ($value !== null) {
            return $value;
        }

        // TO DO: parse other special character month formats
        // Formats to support:
        //      Field name      Mandatory?  Allowed values      Allowed special characters
        //      Month           Yes         1-12 or JAN-DEC     * / , -

        throw new InvalidArgumentException('Invalid cron expression field: "' . $expMonth . '".');
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * @param integer|string     $expDayOfMonth The day of month part of the cron expression.
     * @param TimePointInterface $timePoint     The timepoint to resolve against.
     *
     * @return integer                  The day offset from timepoint for next schedule.
     * @throws InvalidArgumentException
     */
    public function parseDayOfMonthExpression($expDayOfMonth, TimePointInterface $timePoint)
    {
        TypeCheck::get(__CLASS__)->parseDayOfMonthExpression(func_get_args());

        if ($expDayOfMonth === '*') {
            return 0;
        }

        $value = $this->parseIntegerExpression($expDayOfMonth, 1, 31, $timePoint->day());
        if ($value !== null) {
            return $value;
        }

        // TO DO: parse other special character day of month formats
        // Formats to support:
        //      Field name      Mandatory?  Allowed values      Allowed special characters
        //      Day of month    Yes         1-31                * / , - ? L W

        throw new InvalidArgumentException('Invalid cron expression field: "' . $expDayOfMonth . '".');
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * @param integer|string     $expDayOfWeek The day of week part of the cron expression.
     * @param TimePointInterface $timePoint    The timepoint to resolve against.
     *
     * @return integer                  The day offset from timepoint for next schedule.
     * @throws InvalidArgumentException
     */
    public function parseDayOfWeekExpression($expDayOfWeek, TimePointInterface $timePoint)
    {
        TypeCheck::get(__CLASS__)->parseDayOfWeekExpression(func_get_args());

        if ($expDayOfWeek === '*') {
            return 0;
        }

        $value = $this->parseIntegerExpression($expDayOfWeek, 0, 6, $timePoint->isoDayOfWeek() % 7);
        if ($value !== null) {
            return $value;
        }

        $value = $this->parseDayNameExpression($expDayOfWeek, $timePoint->isoDayOfWeek() % 7);
        if ($value !== null) {
            return $value;
        }

        // TO DO: parse other special character day of week formats
        // Formats to support:
        //      Field name      Mandatory?  Allowed values      Allowed special characters
        //      Day of week     Yes         0-6 or SUN-SAT      * / , - ? L #

        throw new InvalidArgumentException('Invalid cron expression field: "' . $expDayOfWeek . '".');
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * @param integer|string     $expDayOfMonth The day of month part of the cron expression.
     * @param integer|string     $expDayOfWeek  The day of week part of the cron expression.
     * @param TimePointInterface $timePoint     The timepoint to resolve against.
     *
     * @return integer                  The day offset from timepoint for next schedule.
     * @throws InvalidArgumentException
     */
    public function parseDayExpression($expDayOfMonth, $expDayOfWeek, TimePointInterface $timePoint)
    {
        TypeCheck::get(__CLASS__)->parseDayExpression(func_get_args());

        if ($expDayOfMonth === '*' && $expDayOfWeek === '*') {
            return 0;
        } elseif ($expDayOfMonth !== '*' && $expDayOfWeek === '*') {
            return $this->parseDayOfMonthExpression($expDayOfMonth, $timePoint);
        } elseif ($expDayOfMonth === '*' && $expDayOfWeek !== '*') {
            return $this->parseDayOfWeekExpression($expDayOfWeek, $timePoint);
        }

        return min(
            $this->parseDayOfMonthExpression($expDayOfMonth, $timePoint),
            $this->parseDayOfWeekExpression($expDayOfWeek, $timePoint)
        );
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * @param integer|string     $expHour   The hour part of the cron expression.
     * @param TimePointInterface $timePoint The timepoint to resolve against.
     *
     * @return integer                  The hour offset from timepoint for next schedule.
     * @throws InvalidArgumentException
     */
    public function parseHourExpression($expHour, TimePointInterface $timePoint)
    {
        TypeCheck::get(__CLASS__)->parseHourExpression(func_get_args());

        if ($expHour === '*') {
            return 0;
        }

        $value = $this->parseIntegerExpression($expHour, 0, 23, $timePoint->hour());
        if ($value !== null) {
            return $value;
        }

        // TO DO: parse other special character hour formats
        // Formats to support:
        //      Field name      Mandatory?  Allowed values      Allowed special characters
        //      Hours           Yes         0-23                * / , -

        throw new InvalidArgumentException('Invalid cron expression field: "' . $expHour . '".');
    }

    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * @param integer|string     $expMinute The minute part of the cron expression.
     * @param TimePointInterface $timePoint The timepoint to resolve against.
     *
     * @return integer                  The minute offset from timepoint for next schedule.
     * @throws InvalidArgumentException
     */
    public function parseMinuteExpression($expMinute, TimePointInterface $timePoint)
    {
        TypeCheck::get(__CLASS__)->parseMinuteExpression(func_get_args());

        if ($expMinute === '*') {
            return 0;
        }

        $value = $this->parseIntegerExpression($expMinute, 0, 59, $timePoint->minute());
        if ($value !== null) {
            return $value;
        }

        // TO DO: parse other special character minute formats
        // Formats to support:
        //      Field name      Mandatory?  Allowed values      Allowed special characters
        //      Minutes         Yes         0-59                * / , -

        throw new InvalidArgumentException('Invalid cron expression field: "' . $expMinute . '".');
    }

    /**
     * @param integer|string $expressionField The expression field of the cron expression.
     * @param integer        $timePointValue  The timepoint value to resolve against.
     *
     * @return integer|null             The value offset from timepoint value for next schedule, or null if not day name format.
     * @throws InvalidArgumentException
     */
    protected function parseDayNameExpression($expressionField, $timePointValue)
    {
        TypeCheck::get(__CLASS__)->parseDayNameExpression(func_get_args());

        $dayNumber = array_search(strtoupper($expressionField), $this->dayNames());
        if ($dayNumber === false) {
            return null;
        }

        return $this->calculateIntegerOffset($dayNumber, 0, 6, $timePointValue);
    }

    /**
     * @param integer|string $expressionField The expression field of the cron expression.
     * @param integer        $timePointValue  The timepoint value to resolve against.
     *
     * @return integer|null             The value offset from timepoint value for next schedule, or null if not month name format.
     * @throws InvalidArgumentException
     */
    protected function parseMonthNameExpression($expressionField, $timePointValue)
    {
        TypeCheck::get(__CLASS__)->parseMonthNameExpression(func_get_args());

        $monthNumber = array_search(strtoupper($expressionField), $this->monthNames());
        if ($monthNumber === false) {
            return null;
        }

        return $this->calculateIntegerOffset($monthNumber, 1, 12, $timePointValue);
    }

    /**
     * @param integer|string $expressionField The expression field of the cron expression.
     * @param integer        $minValue        The minimum value for this field in the cron expression.
     * @param integer        $maxValue        The maximum value for this field in the cron expression.
     * @param integer        $timePointValue  The timepoint value to resolve against.
     *
     * @return integer|null             The value offset from timepoint value for next schedule, or null if not integer format.
     * @throws InvalidArgumentException
     */
    protected function parseIntegerExpression($expressionField, $minValue, $maxValue, $timePointValue)
    {
        TypeCheck::get(__CLASS__)->parseIntegerExpression(func_get_args());

        if (!preg_match('/^\d+$/', $expressionField)) {
            return null;
        }

        return $this->calculateIntegerOffset(intval($expressionField), $minValue, $maxValue, $timePointValue);
    }

    /**
     * @param integer $value          The expression field value.
     * @param integer $minValue       The minimum value for this field in the cron expression.
     * @param integer $maxValue       The maximum value for this field in the cron expression.
     * @param integer $timePointValue The timepoint value to resolve against.
     *
     * @return integer|null             The value offset from timepoint value for next schedule, or null if not integer format.
     * @throws InvalidArgumentException
     */
    protected function calculateIntegerOffset($value, $minValue, $maxValue, $timePointValue)
    {
        TypeCheck::get(__CLASS__)->calculateIntegerOffset(func_get_args());

        $this->validateRange($value, $minValue, $maxValue);

        // Next event is within this field interval.
        if ($value >= $timePointValue) {
            return $value - $timePointValue;
        }

        // Wrap around to next field interval.
        return ($maxValue + 1) - $timePointValue + $value;
    }

    /**
     * Validate the value range to be between min and max inclusive.
     *
     * @param integer $value The value to validate.
     * @param integer $min   The minimum allowed value.
     * @param integer $max   The maximum allowed value.
     *
     * @throws InvalidArgumentException
     */
    protected function validateRange($value, $min, $max)
    {
        TypeCheck::get(__CLASS__)->validateRange(func_get_args());

        if ($value < $min || $value > $max) {
            throw new InvalidArgumentException('Invalid cron expression field: "' . $value . '".');
        }
    }

    /**
     * @return array<int,string>
     */
    protected function dayNames()
    {
        TypeCheck::get(__CLASS__)->dayNames(func_get_args());

        return array(
            0 => 'SUN',
            1 => 'MON',
            2 => 'TUE',
            3 => 'WED',
            4 => 'THU',
            5 => 'FRI',
            6 => 'SAT'
        );
    }

    /**
     * @return array<int,string>
     */
    protected function monthNames()
    {
        TypeCheck::get(__CLASS__)->monthNames(func_get_args());

        return array(
             1 => 'JAN',
             2 => 'FEB',
             3 => 'MAR',
             4 => 'APR',
             5 => 'MAY',
             6 => 'JUN',
             7 => 'JUL',
             8 => 'AUG',
             9 => 'SEP',
            10 => 'OCT',
            11 => 'NOV',
            12 => 'DEC'
        );
    }

    private $typeCheck;
}
