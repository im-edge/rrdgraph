<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

/**
 * Push a copy of the top n elements onto the stack
 *
 *     a,b,c,d,2,COPY => a,b,c,d,c,d
 */
class Copy extends StackOperator
{
    const NAME = 'COPY';
}
