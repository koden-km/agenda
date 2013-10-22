<?php
namespace Icecave\Agenda\TypeCheck\Validator\Icecave\Agenda\Schedule;

class AbstractScheduleTypeCheck extends \Icecave\Agenda\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function firstEventAfter(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('timePoint', 0, 'Icecave\\Chrono\\TimePointInterface');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function firstEventDuring(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('interval', 0, 'Icecave\\Chrono\\Interval\\IntervalInterface');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

}
