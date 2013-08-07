<?php
namespace Icecave\Agenda\Parser;

use Icecave\Agenda\Parser\CronParser;
use Icecave\Agenda\Schedule\ScheduleInterface;
use Icecave\Agenda\Schedule\HourlySchedule;
use Icecave\Agenda\Schedule\DailySchedule;
use Icecave\Agenda\Schedule\GenericSchedule;
use Icecave\Agenda\Schedule\MonthlySchedule;
use Icecave\Agenda\Schedule\WeeklySchedule;
use Icecave\Agenda\Schedule\YearlySchedule;
use Icecave\Chrono\DateTime;
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
            'Empty expression'                      => array(''),
            'Not enough digits'                     => array('0 1'),
            'Too many digits'                       => array('0 1 2 3 4 5 6'),

            'Invalid integer range hours'           => array(' * 25  *  *  *', '25'),
            'Invalid integer range day of month'    => array(' *  * 32  *  *', '32'),
            'Invalid integer range month'           => array(' *  *  * 13  *', '13'),
            'Invalid integer range day of week'     => array(' *  *  *  *  8', '8'),
        );
    }

    /**
     * @dataProvider invalidExpressionFields
     */
    public function testParseWithInvalidExpressionField($expression, $field)
    {
        $this->setExpectedException('\InvalidArgumentException', 'Invalid cron expression field: "' . $field . '".');
        $this->parser->parse($expression);
    }

    public function invalidExpressionFields()
    {
        return array(
            'Invalid character minutes'             => array('X * * * *', 'X'),
            'Invalid character hours'               => array('* X * * *', 'X'),
            'Invalid character day of month'        => array('* * X * *', 'X'),
            'Invalid character month'               => array('* * * X *', 'X'),
            'Invalid character day of week'         => array('* * * * X', 'X'),

            'Invalid integer range minutes'         => array('61  *  *  *  *', '61'),

            'Invalid month name'                    => array('* * * Foo *', 'Foo'),
            'Invalid day of week name'              => array('* * * * Foo', 'Foo'),

            // TO DO: special character formats
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

    /**
     * @link https://en.wikipedia.org/wiki/Cron#CRON_expression
     *
     * Formats to test:
     *      Field name      Mandatory?  Allowed values      Allowed special characters
     *      Minutes         Yes         0-59                * / , -
     *      Hours           Yes         0-23                * / , -
     *      Day of month    Yes         1-31                * / , - ? L W
     *      Month           Yes         1-12 or JAN-DEC     * / , -
     *      Day of week     Yes         0-6 or SUN-SAT      * / , - ? L #
     *      Year            No          1970–2099           * / , -
     */
    public function validGenericExpressions()
    {
        $parser = new CronParser;

        return array(
            'Exact hour'        => array(CronParser::EXPRESSION_HOURLY,     new HourlySchedule),
            'Exact day'         => array(CronParser::EXPRESSION_DAILY,      new DailySchedule),
            'Exact week'        => array(CronParser::EXPRESSION_WEEKLY,     new WeeklySchedule),
            'Exact month'       => array(CronParser::EXPRESSION_MONTHLY,    new MonthlySchedule),
            'Exact year'        => array(CronParser::EXPRESSION_YEARLY,     new YearlySchedule),

            'Every minute of every hour of every day'                       => array('* * * * *',       new GenericSchedule($parser, '*', '*', '*', '*', '*')),
            '5 minutes past every hour of every day'                        => array('5 * * * *',       new GenericSchedule($parser, '5', '*', '*', '*', '*')),
            'Every minute of 5 am every day'                                => array('* 5 * * *',       new GenericSchedule($parser, '*', '5', '*', '*', '*')),
            'Every minute of every hour of the 5th of every month'          => array('* * 5 * *',       new GenericSchedule($parser, '*', '*', '5', '*', '*')),
            'Every minute of every hour of every day of 5th month (May)'    => array('* * * 5 *',       new GenericSchedule($parser, '*', '*', '*', '5', '*')),
            'Every minute of every hour of every 5th day (Friday)'          => array('* * * * 5',       new GenericSchedule($parser, '*', '*', '*', '*', '5')),

            'Every minute of every hour of every day of May'                => array('* * * May *',     new GenericSchedule($parser, '*', '*', '*', 'May', '*')),
            'Every minute of every hour of every Friday'                    => array('* * * * Fri',     new GenericSchedule($parser, '*', '*', '*', '*', 'Fri')),

            'At 2:01am on the 3rd of April, or every Friday in April'                       => array('1 2 3 4 5',       new GenericSchedule($parser, '1', '2', '3', '4', '5')),
            'Every minute of every hour of the 5th day, or every Saturday; in every month'  => array('* * 5 * 6',       new GenericSchedule($parser, '*', '*', '5', '*', '6')),

            // TO DO: special character formats

            // run every two hours, at midnight, 2am, 4am, 6am, 8am, and so on
            // 'Every two hours, at midnight'      => array('0 */2 * * *',     new GenericSchedule($parser, '0', '*/2', '*', '*', '*')),
        );
    }

    public function testParseDayOfMonthExpressionWithStar()
    {
        $this->assertEquals(0, $this->parser->parseDayOfMonthExpression('*', new DateTime(2010, 1, 1)));
    }

    public function testParseDayOfWeekExpressionWithStar()
    {
        $this->assertEquals(0, $this->parser->parseDayOfWeekExpression('*', new DateTime(2010, 1, 1)));
    }
}
