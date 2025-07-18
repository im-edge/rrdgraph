<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Reverse the number
 *
 * Example: CDEF:x=v1,v2,v3,v4,v5,v6,6,SORT,POP,5,REV,POP,+,+,+,4,/
 *          will compute the average of the values v1 to v6 after removing the
 *          smallest and largest.
 */
class Reverse extends SetOperator
{
    public const NAME = 'REV';
}
