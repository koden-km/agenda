<?php
namespace Icecave\Agenda\Parser;

use PHPUnit_Framework_TestCase;

class CronParserTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->parser = new CronParser;
    }

    public function testParseWithFormatHourly()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\HourlySchedule', $this->parser->parse('@hourly'));
        $this->assertInstanceOf('Icecave\Agenda\Schedule\HourlySchedule', $this->parser->parse('0 * * * *'));
    }

    public function testParseWithFormatDaily()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\DailySchedule', $this->parser->parse('@daily'));
        $this->assertInstanceOf('Icecave\Agenda\Schedule\DailySchedule', $this->parser->parse('0 0 * * *'));
    }

    public function testParseWithFormatWeekly()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\WeeklySchedule', $this->parser->parse('@weekly'));
        $this->assertInstanceOf('Icecave\Agenda\Schedule\WeeklySchedule', $this->parser->parse('0 0 * * 0'));
    }

    public function testParseWithFormatMonthly()
    {
         $this->assertInstanceOf('Icecave\Agenda\Schedule\MonthlySchedule', $this->parser->parse('@monthly'));
         $this->assertInstanceOf('Icecave\Agenda\Schedule\MonthlySchedule', $this->parser->parse('0 0 1 * *'));
    }

    public function testParseWithFormatYearly()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\YearlySchedule', $this->parser->parse('@yearly'));
        $this->assertInstanceOf('Icecave\Agenda\Schedule\YearlySchedule', $this->parser->parse('@annually'));
        $this->assertInstanceOf('Icecave\Agenda\Schedule\YearlySchedule', $this->parser->parse('0 0 1 1 *'));
    }

    public function testParseWithInvalidFormat()
    {
        $this->setExpectedException('\InvalidArgumentException', 'Invalid cron expression: "@wrong".');
        $this->parser->parse('@wrong');
    }
}
