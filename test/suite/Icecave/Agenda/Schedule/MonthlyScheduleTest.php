<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Interval;
use PHPUnit_Framework_TestCase;

class MonthlyScheduleTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->schedule = new MonthlySchedule;
    }

    /**
     * @dataProvider validFirstEventFromDates
     */
    public function testFirstEventFrom($dateTime, $expected)
    {
        $dateTime = DateTime::fromIsoString($dateTime);
        $expected = DateTime::fromIsoString($expected);

        $this->assertEquals($expected, $this->schedule->firstEventFrom($dateTime));
    }

    public function validFirstEventFromDates()
    {
        return array(
            'Exact match'       => array('2013-10-01 00:00:00', '2013-10-01 00:00:00'),
            'Time offset'       => array('2013-10-01 10:20:30', '2013-11-01 00:00:00'),
            'Date offset'       => array('2013-10-20 00:00:00', '2013-11-01 00:00:00'),
            'Date time offset'  => array('2013-10-20 10:10:30', '2013-11-01 00:00:00'),
            'Wrap year'         => array('2013-12-20 10:20:30', '2014-01-01 00:00:00'),
        );
    }

    /**
     * @dataProvider validFirstEventAfterDates
     * @covers       Icecave\Agenda\Schedule\AbstractSchedule
     */
    public function testFirstEventAfter($dateTime, $expected)
    {
        $dateTime = DateTime::fromIsoString($dateTime);
        $expected = DateTime::fromIsoString($expected);

        $this->assertEquals($expected, $this->schedule->firstEventAfter($dateTime));
    }

    public function validFirstEventAfterDates()
    {
        return array(
            'Exact month'       => array('2013-10-01 00:00:00', '2013-11-01 00:00:00'),
            'Time offset'       => array('2013-10-01 10:20:30', '2013-11-01 00:00:00'),
            'Date offset'       => array('2013-10-20 00:00:00', '2013-11-01 00:00:00'),
            'Date time offset'  => array('2013-10-20 10:20:30', '2013-11-01 00:00:00'),
            'Wrap year'         => array('2013-12-31 10:20:30', '2014-01-01 00:00:00'),
        );
    }

    /**
     * @dataProvider validFirstEventDuringDates
     * @covers       Icecave\Agenda\Schedule\AbstractSchedule
     */
    public function testFirstEventDuring($dateTimeStart, $dateTimeEnd, $expected)
    {
        $interval = new Interval(
            DateTime::fromIsoString($dateTimeStart),
            DateTime::fromIsoString($dateTimeEnd)
        );
        $expected = DateTime::fromIsoString($expected);

        $this->assertEquals($expected, $this->schedule->firstEventDuring($interval));
    }

    public function validFirstEventDuringDates()
    {
        return array(
            'Exact month'       => array('2013-10-01 00:00:00', '2013-11-01 00:00:00', '2013-10-01 00:00:00'),
            'Time offset'       => array('2013-10-01 10:20:30', '2013-11-01 10:20:30', '2013-11-01 00:00:00'),
            'Date offset'       => array('2013-10-20 00:00:00', '2013-11-20 00:00:00', '2013-11-01 00:00:00'),
            'Date time offset'  => array('2013-10-20 10:20:30', '2013-11-20 10:20:30', '2013-11-01 00:00:00'),
            'Wrap year'         => array('2013-12-31 10:20:30', '2014-01-31 10:20:30', '2014-01-01 00:00:00'),
        );
    }

    /**
     * @dataProvider invalidFirstEventDuringDates
     * @covers       Icecave\Agenda\Schedule\AbstractSchedule
     */
    public function testFirstEventDuringWithNoMatch($dateTimeStart, $dateTimeEnd)
    {
        $interval = new Interval(
            DateTime::fromIsoString($dateTimeStart),
            DateTime::fromIsoString($dateTimeEnd)
        );

        $this->assertNull($this->schedule->firstEventDuring($interval));
    }

    public function invalidFirstEventDuringDates()
    {
        return array(
            'No full month'         => array('2013-10-20 10:20:30', '2013-10-30 10:20:30'),
            'Exact duration end'    => array('2013-10-20 10:20:30', '2013-11-00 00:00:00'),
        );
    }
}
