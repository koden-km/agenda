<?php
namespace Icecave\Agenda\Parser;

use Icecave\Agenda\Schedule\ScheduleInterface;
use Icecave\Agenda\Schedule\HourlySchedule;
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
            'Empty expression'    => array(''),
            'Not enough digits'   => array('0 1'),
            'Too many digits'     => array('0 1 2 3 4 5 6'),
            'Invalid character'   => array('0 * A * *'),
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
            'Exact hour'        => array('0 * * * *',       new HourlySchedule),
        );
    }
}
