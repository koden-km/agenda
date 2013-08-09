<?php
namespace Icecave\Agenda\TypeCheck\Validator\Icecave\Agenda\Parser;

class CronParserTypeCheck extends \Icecave\Agenda\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function parse(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expression', 0, 'string');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expression',
                0,
                $arguments[0],
                'string'
            );
        }
    }

    public function tryParse(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expression', 0, 'string');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expression',
                0,
                $arguments[0],
                'string'
            );
        }
    }

    public function tryParsePredefinedFormat(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expression', 0, 'string');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expression',
                0,
                $arguments[0],
                'string'
            );
        }
    }

    public function tryParsePredefinedExpressionFormat(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expression', 0, 'string');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expression',
                0,
                $arguments[0],
                'string'
            );
        }
    }

    public function tryParseExpressionFormat(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expression', 0, 'string');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expression',
                0,
                $arguments[0],
                'string'
            );
        }
    }

    public function parseMonthExpression(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expMonth', 0, 'integer|string');
            }
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('timePoint', 1, 'Icecave\\Chrono\\TimePointInterface');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expMonth',
                0,
                $arguments[0],
                'integer|string'
            );
        }
    }

    public function parseDayOfMonthExpression(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expDayOfMonth', 0, 'integer|string');
            }
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('timePoint', 1, 'Icecave\\Chrono\\TimePointInterface');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expDayOfMonth',
                0,
                $arguments[0],
                'integer|string'
            );
        }
    }

    public function parseDayOfWeekExpression(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expDayOfWeek', 0, 'integer|string');
            }
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('timePoint', 1, 'Icecave\\Chrono\\TimePointInterface');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expDayOfWeek',
                0,
                $arguments[0],
                'integer|string'
            );
        }
    }

    public function parseDayExpression(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expDayOfMonth', 0, 'integer|string');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expDayOfWeek', 1, 'integer|string');
            }
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('timePoint', 2, 'Icecave\\Chrono\\TimePointInterface');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
        $value = $arguments[0];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expDayOfMonth',
                0,
                $arguments[0],
                'integer|string'
            );
        }
        $value = $arguments[1];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expDayOfWeek',
                1,
                $arguments[1],
                'integer|string'
            );
        }
    }

    public function parseHourExpression(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expHour', 0, 'integer|string');
            }
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('timePoint', 1, 'Icecave\\Chrono\\TimePointInterface');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expHour',
                0,
                $arguments[0],
                'integer|string'
            );
        }
    }

    public function parseMinuteExpression(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expMinute', 0, 'integer|string');
            }
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('timePoint', 1, 'Icecave\\Chrono\\TimePointInterface');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expMinute',
                0,
                $arguments[0],
                'integer|string'
            );
        }
    }

    public function parseDayNameExpression(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expressionField', 0, 'integer|string');
            }
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('timePointValue', 1, 'integer');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expressionField',
                0,
                $arguments[0],
                'integer|string'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'timePointValue',
                1,
                $arguments[1],
                'integer'
            );
        }
    }

    public function parseMonthNameExpression(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expressionField', 0, 'integer|string');
            }
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('timePointValue', 1, 'integer');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expressionField',
                0,
                $arguments[0],
                'integer|string'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'timePointValue',
                1,
                $arguments[1],
                'integer'
            );
        }
    }

    public function parseIntegerExpression(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 4) {
            if ($argumentCount < 1) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('expressionField', 0, 'integer|string');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('minValue', 1, 'integer');
            }
            if ($argumentCount < 3) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('maxValue', 2, 'integer');
            }
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('timePointValue', 3, 'integer');
        } elseif ($argumentCount > 4) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(4, $arguments[4]);
        }
        $value = $arguments[0];
        if (!(\is_int($value) || \is_string($value))) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'expressionField',
                0,
                $arguments[0],
                'integer|string'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'minValue',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'maxValue',
                2,
                $arguments[2],
                'integer'
            );
        }
        $value = $arguments[3];
        if (!\is_int($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'timePointValue',
                3,
                $arguments[3],
                'integer'
            );
        }
    }

    public function calculateIntegerOffset(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 4) {
            if ($argumentCount < 1) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('value', 0, 'integer');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('minValue', 1, 'integer');
            }
            if ($argumentCount < 3) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('maxValue', 2, 'integer');
            }
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('timePointValue', 3, 'integer');
        } elseif ($argumentCount > 4) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(4, $arguments[4]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'value',
                0,
                $arguments[0],
                'integer'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'minValue',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'maxValue',
                2,
                $arguments[2],
                'integer'
            );
        }
        $value = $arguments[3];
        if (!\is_int($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'timePointValue',
                3,
                $arguments[3],
                'integer'
            );
        }
    }

    public function validateRange(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('value', 0, 'integer');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('min', 1, 'integer');
            }
            throw new \Icecave\Agenda\TypeCheck\Exception\MissingArgumentException('max', 2, 'integer');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'value',
                0,
                $arguments[0],
                'integer'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'min',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentValueException(
                'max',
                2,
                $arguments[2],
                'integer'
            );
        }
    }

    public function dayNames(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function monthNames(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Agenda\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

}
