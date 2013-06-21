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

    public function tryParseConstantFormat(array $arguments)
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

    public function tryParseColumnFormat(array $arguments)
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

}
