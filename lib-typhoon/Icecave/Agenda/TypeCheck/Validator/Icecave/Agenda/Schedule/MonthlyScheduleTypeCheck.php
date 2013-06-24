<?php
namespace Icecave\Agenda\TypeCheck\Validator\Icecave\Agenda\Schedule;

class MonthlyScheduleTypeCheck extends \Icecave\Agenda\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function firstEventFrom(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('timePoint', 0, 'Icecave\\Chrono\\TimePointInterface');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

}
