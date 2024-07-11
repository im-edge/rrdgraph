<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Pushes an unknown value on the stack
 */
class Unknown extends SpecialValue
{
    const NAME = 'UNKN';
}
