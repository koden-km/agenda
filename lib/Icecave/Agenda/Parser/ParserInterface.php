<?php
namespace Icecave\Agenda\Parser;

interface ParserInterface
{
    /**
     * @param string $expression
     *
     * @return ScheduleInterface
     * @throws InvalidArgumentException
     */
    public function parse($expression);

    /**
     * @param string $expression
     * @param ScheduleInterface &$schedule = null The schedule to store the parsed result in.
     *
     * @return boolean True if the expression parsed successfully.
     */
    public function tryParse($expression, ScheduleInterface &$schedule = null);
}
