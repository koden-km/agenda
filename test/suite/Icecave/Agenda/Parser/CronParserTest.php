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
    }

    public function testParseWithFormatDaily()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\DailySchedule', $this->parser->parse('@daily'));
    }

    public function testParseWithFormatWeekly()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\WeeklySchedule', $this->parser->parse('@weekly'));
    }

    public function testParseWithFormatMonthly()
    {
         $this->assertInstanceOf('Icecave\Agenda\Schedule\MonthlySchedule', $this->parser->parse('@monthly'));
    }

    public function testParseWithFormatYearly()
    {
        $this->assertInstanceOf('Icecave\Agenda\Schedule\YearlySchedule', $this->parser->parse('@yearly'));
    }
}
