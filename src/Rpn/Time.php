<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Pushes the time the currently processed value was taken at onto the stack
 */
class Time extends TimeValue
{
    public const NAME = 'TIME';
}
