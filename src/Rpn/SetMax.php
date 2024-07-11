<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Pop one element (count) from the stack. Now pop count elements and push the
 * maximum back onto the stack.
 *
 * Example: CDEF:x=a,b,c,d,4,SMIN
 */
class SetMax extends SetOperator
{
    const NAME = 'SMAX';
}
