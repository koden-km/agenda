<?php
namespace Icecave\Agenda\Schedule;

use Icecave\Agenda\Parser\CronParser;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Interval;
use PHPUnit_Framework_TestCase;

class GenericScheduleTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->parser = new CronParser;
    }

    /**
     * @dataProvider validFirstEventFromDates
     */
    public function testFirstEventFrom($schedule, $dateTime, $expected)
    {
        $schedule = $this->parser->parse($schedule);
        $dateTime = DateTime::fromIsoString($dateTime);
        $expected = DateTime::fromIsoString($expected);

        $this->assertEquals($expected, $schedule->firstEventFrom($dateTime));
    }

    public function validFirstEventFromDates()
    {
        return array(
            // Every minute of every hour of every day
            'Exact match: Every minute of every hour of every day'  => array('* * * * *', '2013-10-20 00:00:00', '2013-10-20 00:00:00'),
            'Time offset: Every minute of every hour of every day'  => array('* * * * *', '2013-10-20 10:11:00', '2013-10-20 10:11:00'),
            'Wrap period: Every minute of every hour of every day'  => array('* * * * *', '2013-10-20 10:11:12', '2013-10-20 10:12:00'),

            // 5 minutes past every hour of every day
            'Exact match: 5 minutes past every hour of every day'   => array('5 * * * *', '2013-10-20 00:00:00', '2013-10-20 00:05:00'),
            'Time offset: 5 minutes past every hour of every day'   => array('5 * * * *', '2013-10-20 10:01:02', '2013-10-20 10:05:00'),
            'Wrap period: 5 minutes past every hour of every day'   => array('5 * * * *', '2013-10-20 10:11:12', '2013-10-20 11:05:00'),

            // Every minute of 5am of every day
            'Exact match: Every minute of 5am of every day'  => array('* 5 * * *', '2013-10-20 05:00:00', '2013-10-20 05:00:00'),
            'Time offset: Every minute of 5am of every day'  => array('* 5 * * *', '2013-10-20 05:11:12', '2013-10-20 05:11:00'),
            'Wrap period: Every minute of 5am of every day'  => array('* 5 * * *', '2013-10-20 10:11:12', '2013-10-21 05:00:00'),

            // Every minute of every hour of the fifth of every month
            'Exact match: Every minute of every hour of the fifth of every month'   => array('* * 5 * *', '2013-10-05 00:00:00', '2013-10-05 00:00:00'),
            'Time offset: Every minute of every hour of the fifth of every month'   => array('* * 5 * *', '2013-10-05 10:11:12', '2013-10-05 10:11:12'),
            'Wrap period: Every minute of every hour of the fifth of every month'   => array('* * 5 * *', '2013-10-20 10:11:12', '2013-11-05 00:00:00'),

            // Every minute of every hour of every day of May
            'Exact match: Every minute of every hour of every day of May'   => array('* * * 5 *', '2013-05-20 00:00:00', '2013-05-20 00:00:00'),
            'Time offset: Every minute of every hour of every day of May'   => array('* * * 5 *', '2013-05-20 10:01:02', '2013-05-20 10:02:00'),
            'Wrap period: Every minute of every hour of every day of May'   => array('* * * 5 *', '2013-10-20 10:11:12', '2014-05-01 00:00:00'),

            // Every minute of every hour of every Friday
            'Exact match: Every minute of every hour of every Friday'   => array('* * * * 5', '2013-10-18 00:00:00', '2013-10-18 00:00:00'),
            'Time offset: Every minute of every hour of every Friday'   => array('* * * * 5', '2013-10-18 10:01:02', '2013-10-18 10:02:00'),
            'Wrap period: Every minute of every hour of every Friday'   => array('* * * * 5', '2013-10-20 10:11:12', '2013-10-25 00:00:0'),

            // Every minute of every hour of the fifth of -- or every Saturday in -- every month
            'Exact match: Every minute of every hour of the fifth of --- every month'   => array('* * 5 * 6', '2013-10-05 00:00:00', '2013-10-05 00:00:00'),
            'Time offset: Every minute of every hour of the fifth of --- every month'   => array('* * 5 * 6', '2013-10-05 10:01:02', '2013-10-05 10:02:00'),
            'Wrap period: Every minute of every hour of the fifth of --- every month'   => array('* * 5 * 6', '2013-10-20 10:11:12', '2013-11-05 00:00:00'),
            // Every minute of every hour of the fifth of -- or every Saturday in -- every month
            'Exact match: Every Saturday in -- every month'                             => array('* * 5 * 6', '2013-10-12 00:00:00', '2013-10-12 00:00:00'),
            'Time offset: Every Saturday in -- every month'                             => array('* * 5 * 6', '2013-10-12 10:01:02', '2013-10-19 00:00:00'),
            'Wrap period: Every Saturday in -- every month'                             => array('* * 5 * 6', '2013-10-20 10:11:12', '2013-10-26 00:00:00'),

            // 2:01am on the third of -- or every Friday in -- April
            'Exact match: 2:01am on the third of -- April'  => array('1 2 3 4 5', '2013-04-03 02:01:00', '2013-04-03 02:01:00'),
            'Time offset: 2:01am on the third of -- April'  => array('1 2 3 4 5', '2013-04-03 01:02:03', '2013-04-03 02:01:00'),
            'Wrap period: 2:01am on the third of -- April'  => array('1 2 3 4 5', '2013-04-03 10:11:12', '2014-04-03 00:00:00'),
            // 2:01am on the third of -- or every Friday in -- April
            'Exact match: Every Friday in -- April'         => array('1 2 3 4 5', '2013-04-05 00:00:00', '2013-04-05 00:00:00'),
            'Time offset: Every Friday in -- April'         => array('1 2 3 4 5', '2013-04-05 10:01:02', '2013-04-12 00:00:00'),
            'Wrap period: Every Friday in -- April'         => array('1 2 3 4 5', '2013-04-26 10:11:12', '2014-04-04 00:00:00'),
        );
    }
}
