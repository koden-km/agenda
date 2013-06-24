<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Interval;
use PHPUnit_Framework_TestCase;

class DailyScheduleTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->schedule = new DailySchedule;
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
            'Exact match'   => array('2013-10-20 00:00:00', '2013-10-20 00:00:00'),
            'Time offset'   => array('2013-10-20 10:11:12', '2013-10-21 00:00:00'),
            'Wrap month'    => array('2013-10-31 10:11:12', '2013-11-01 00:00:00'),
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
            'Exact day'     => array('2013-10-20 00:00:00', '2013-10-21 00:00:00'),
            'Time offset'   => array('2013-10-20 10:20:30', '2013-10-21 00:00:00'),
            'Wrap month'    => array('2013-10-31 10:20:30', '2013-11-01 00:00:00'),
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
            'Exact day'     => array('2013-10-20 00:00:00', '2013-10-30 00:00:00', '2013-10-20 00:00:00'),
            'Time offset'   => array('2013-10-20 10:20:30', '2013-10-30 10:20:30', '2013-10-21 00:00:00'),
            'Wrap month'    => array('2013-10-31 10:20:30', '2013-11-20 15:00:00', '2013-11-01 00:00:00'),
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
            'No full day'           => array('2013-10-20 10:10:10', '2013-10-20 20:20:20'),
            'Exact duration end'    => array('2013-10-20 10:20:30', '2013-10-21 00:00:00'),
        );
    }
}
