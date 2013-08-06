<?php
namespace Icecave\Agenda\Parser;

use Icecave\Agenda\Schedule\ScheduleInterface;
use Icecave\Agenda\Schedule\HourlySchedule;
use Icecave\Agenda\Schedule\DailySchedule;
use Icecave\Agenda\Schedule\GenericSchedule;
use Icecave\Agenda\Schedule\MonthlySchedule;
use Icecave\Agenda\Schedule\WeeklySchedule;
use Icecave\Agenda\Schedule\YearlySchedule;
use PHPUnit_Framework_TestCase;

class CronParserTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->parser = new CronParser;
    }

    public function testParseWithPredefinedHourly()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\HourlySchedule', $this->parser->parse(CronParser::PREDEFINED_HOURLY));
    }

    public function testParseWithPredefinedDaily()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\DailySchedule', $this->parser->parse(CronParser::PREDEFINED_DAILY));
    }

    public function testParseWithPredefinedWeekly()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\WeeklySchedule', $this->parser->parse(CronParser::PREDEFINED_WEEKLY));
    }

    public function testParseWithPredefinedMonthly()
    {
         $this->assertInstanceOf('Icecave\Agenda\Schedule\MonthlySchedule', $this->parser->parse(CronParser::PREDEFINED_MONTHLY));
    }

    public function testParseWithPredefinedYearly()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\YearlySchedule', $this->parser->parse(CronParser::PREDEFINED_YEARLY));
    }

    public function testParseWithPredefinedAnnually()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\YearlySchedule', $this->parser->parse(CronParser::PREDEFINED_ANNUALLY));
    }

    public function testParseWithExpressionHourly()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\HourlySchedule', $this->parser->parse(CronParser::EXPRESSION_HOURLY));
    }

    public function testParseWithExpressionDaily()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\DailySchedule', $this->parser->parse(CronParser::EXPRESSION_DAILY));
    }

    public function testParseWithExpressionWeekly()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\WeeklySchedule', $this->parser->parse(CronParser::EXPRESSION_WEEKLY));
    }

    public function testParseWithExpressionMonthly()
    {
         $this->assertInstanceOf('Icecave\Agenda\Schedule\MonthlySchedule', $this->parser->parse(CronParser::EXPRESSION_MONTHLY));
    }

    public function testParseWithExpressionYearly()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\YearlySchedule', $this->parser->parse(CronParser::EXPRESSION_YEARLY));
    }

    public function testParseWithInvalidPredefinedFormat()
    {
        $this->setExpectedException('\InvalidArgumentException', 'Invalid cron expression: "@wrong".');
        $this->parser->parse('@wrong');
    }

    /**
     * @dataProvider invalidExpressions
     */
    public function testParseWithInvalidExpression($expression)
    {
        $this->setExpectedException('\InvalidArgumentException', 'Invalid cron expression: "' . $expression . '".');
        $this->parser->parse($expression);
    }

    public function invalidExpressions()
    {
        return array(
            'Empty expression'                  => array(''),
            'Not enough digits'                 => array('0 1'),
            'Too many digits'                   => array('0 1 2 3 4 5 6'),

            // https://en.wikipedia.org/wiki/Cron#CRON_expression
            // Formats to test:
            //      Field name      Mandatory?  Allowed values      Allowed special characters
            //      Minutes         Yes         0-59                * / , -
            //      Hours           Yes         0-23                * / , -
            //      Day of month    Yes         1-31                * / , - ? L W
            //      Month           Yes         1-12 or JAN-DEC     * / , -
            //      Day of week     Yes         0-6 or SUN-SAT      * / , - ? L #
            //      Year            No          1970–2099           * / , -

            // 'Invalid minutes character'         => array('A * * * *'),
        );
    }

    /**
     * @dataProvider validGenericExpressions
     */
    public function testParseWithGenericExpression($expression, $expected)
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\ScheduleInterface', $expected);
        $this->assertEquals($expected, $this->parser->parse($expression));
    }

    public function validGenericExpressions()
    {
        return array(
            'Exact hour'        => array(CronParser::EXPRESSION_HOURLY,     new HourlySchedule),
            'Exact day'         => array(CronParser::EXPRESSION_DAILY,      new DailySchedule),
            'Exact week'        => array(CronParser::EXPRESSION_WEEKLY,     new WeeklySchedule),
            'Exact month'       => array(CronParser::EXPRESSION_MONTHLY,    new MonthlySchedule),
            'Exact year'        => array(CronParser::EXPRESSION_YEARLY,     new YearlySchedule),

            'Every 5 minutes'                   => array('5 * * * *',       new GenericSchedule('5', '*', '*', '*', '*')),

            // run every two hours, at midnight, 2am, 4am, 6am, 8am, and so on
            'Every two hours, at midnight'      => array('0 */2 * * *',     new GenericSchedule('0', '*/2', '*', '*', '*')),

            // https://en.wikipedia.org/wiki/Cron#CRON_expression
            // While normally the job is executed when the time/date specification fields all match the current time and date,
            // there is one exception:
            // if both "day of month" and "day of week" are restricted (not "*"),
            // then either the "day of month" field (3) or the "day of week" field (5) must match the current day.
            //
            // Formats to test:
            //      Field name      Mandatory?  Allowed values      Allowed special characters
            //      Minutes         Yes         0-59                * / , -
            //      Hours           Yes         0-23                * / , -
            //      Day of month    Yes         1-31                * / , - ? L W
            //      Month           Yes         1-12 or JAN-DEC     * / , -
            //      Day of week     Yes         0-6 or SUN-SAT      * / , - ? L #
            //      Year            No          1970–2099           * / , -


        );
    }
}
