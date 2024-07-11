<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Pushes the current time on the stack
 */
class Now extends TimeValue
{
    const NAME = 'NOW';
}
