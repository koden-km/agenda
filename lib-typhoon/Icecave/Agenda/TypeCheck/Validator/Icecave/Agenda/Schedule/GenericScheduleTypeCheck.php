<?php
namespace Icecave\Agenda\TypeCheck\Validator\Icecave\Agenda\Schedule;

class GenericScheduleTypeCheck extends \Icecave\Agenda\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 6) {
            if ($argumentCount < 1) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('parser', 0, 'Icecave\\Agenda\\Parser\\CronParser');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('minute', 1, 'integer|string');
            }
            if ($argumentCount < 3) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('hour', 2, 'integer|string');
            }
            if ($argumentCount < 4) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('dayOfMonth', 3, 'integer|string');
            }
            if ($argumentCount < 5) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('month', 4, 'integer|string');
            }
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('dayOfWeek', 5, 'integer|string');
        } elseif ($argumentCount > 6) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(6, $arguments[6]);
        }
        $value = $arguments[1];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'minute',
                1,
                $arguments[1],
                'integer|string'
            );
        }
        $value = $arguments[2];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'hour',
                2,
                $arguments[2],
                'integer|string'
            );
        }
        $value = $arguments[3];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'dayOfMonth',
                3,
                $arguments[3],
                'integer|string'
            );
        }
        $value = $arguments[4];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'month',
                4,
                $arguments[4],
                'integer|string'
            );
        }
        $value = $arguments[5];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'dayOfWeek',
                5,
                $arguments[5],
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
