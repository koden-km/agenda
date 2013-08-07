<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Agenda\Parser\CronParser;
use Icecave\Agenda\TypeCheck\TypeCheck;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimePointInterface;

/**
 * Run every schedule interval.
 */
class GenericSchedule extends AbstractSchedule
{
    /**
     * @param CronParser     $parser     The cron parser.
     * @param integer|string $minute     The minute part or null for not applicable.
     * @param integer|string $hour       The hour part or null for not applicable.
     * @param integer|string $dayOfMonth The day of month part or null for not applicable.
     * @param integer|string $month      The month part or null for not applicable.
     * @param integer|string $dayOfWeek  The day of week part or null for not applicable.
     */
    public function __construct(CronParser $parser, $minute, $hour, $dayOfMonth, $month, $dayOfWeek)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
        parent::__construct();

        $this->parser = $parser;
        $this->expMinute = $minute;
        $this->expHour = $hour;
        $this->expDayOfMonth = $dayOfMonth;
        $this->expMonth = $month;
        $this->expDayOfWeek = $dayOfWeek;
    }

    /**
     * @param TimePointInterface $timePoint
     *
     * @return TimePointInterface|null The next scheduled time point.
     */
    public function firstEventFrom(TimePointInterface $timePoint)
    {
        TypeCheck::get(__CLASS__)->firstEventFrom(func_get_args());

        return new DateTime(
            $timePoint->year(),
            $timePoint->month() + $this->parser->parseMonthExpression($this->expMonth, $timePoint),
            $timePoint->day() + $this->parser->parseDayExpression($this->expDayOfMonth, $this->expDayOfWeek, $timePoint),
            $timePoint->hour() + $this->parser->parseHourExpression($this->expHour, $timePoint),
            $timePoint->minute() + $this->parser->parseMinuteExpression($this->expMinute, $timePoint),
            $timePoint->second()
        );
    }

    private $typeCheck;
    private $parser;
    private $expMinute;
    private $expHour;
    private $expDayOfMonth;
    private $expMonth;
    private $expDayOfWeek;
}
