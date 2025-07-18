<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Pushes an unknown value if this is the first value of a data set or
 * otherwise the result of this CDEF at the previous time step. This allows you
 * to do calculations across the data. This function cannot be used in VDEF
 * instructions.
 */
class Previous extends SpecialValue
{
    public const NAME = 'PREV';
}
