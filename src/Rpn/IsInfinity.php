<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Pop one element from the stack, compare this to positive or negative
 * infinity.
 *
 * Returns 1 for true or 0 for false.
 */
class IsInfinity extends BooleanOperator
{
    public const NAME = 'ISINF';

    protected ?int $parameterCount = 1;
}
