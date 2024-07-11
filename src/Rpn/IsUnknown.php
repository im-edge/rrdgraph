<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Pop one element from the stack, compare this to unknown.
 *
 * Returns 1 for true or 0 for false.
 */
class IsUnknown extends BooleanOperator
{
    const NAME = 'UN';

    protected ?int $parameterCount = 1;
}
