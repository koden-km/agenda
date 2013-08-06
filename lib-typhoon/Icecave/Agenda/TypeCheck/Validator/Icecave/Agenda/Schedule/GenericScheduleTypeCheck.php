<?php
namespace Icecave\Agenda\TypeCheck\Validator\Icecave\Agenda\Schedule;

class GenericScheduleTypeCheck extends \Icecave\Agenda\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 5) {
            if ($argumentCount < 1) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('minute', 0, 'integer|string');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('hour', 1, 'integer|string');
            }
            if ($argumentCount < 3) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('dayOfMonth', 2, 'integer|string');
            }
            if ($argumentCount < 4) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('month', 3, 'integer|string');
            }
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('dayOfWeek', 4, 'integer|string');
        } elseif ($argumentCount > 5) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(5, $arguments[5]);
        }
        $value = $arguments[0];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'minute',
                0,
                $arguments[0],
                'integer|string'
            );
        }
        $value = $arguments[1];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'hour',
                1,
                $arguments[1],
                'integer|string'
            );
        }
        $value = $arguments[2];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'dayOfMonth',
                2,
                $arguments[2],
                'integer|string'
            );
        }
        $value = $arguments[3];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'month',
                3,
                $arguments[3],
                'integer|string'
            );
        }
        $value = $arguments[4];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'dayOfWeek',
                4,
                $arguments[4],
                'integer|string'
            );
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
