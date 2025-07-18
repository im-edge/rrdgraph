<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Pushes the current depth of the stack onto the stack
 *
 *     a,b,DEPTH -> a,b,2
 */
class Depth extends StackOperator
{
    public const NAME = 'DEPTH';

    protected bool $isVariadic = false;
    protected ?int $parameterCount = 0;
}
