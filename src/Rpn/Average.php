<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Pop one element (count) from the stack. Now pop count elements and build the
 * average, ignoring all UNKNOWN values in the process.
 *
 * Example: CDEF:x=a,b,c,d,4,AVG
 */
class Average extends SetOperator
{
    public const NAME = 'AVG';
}
