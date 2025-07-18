<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Pops three elements from the stack. If the element popped last is 0 (false),
 * the value popped first is pushed back onto the stack, otherwise the value
 * popped second is pushed back. This does, indeed, mean that any value other
 * than 0 is considered to be true.
 *
 * Example: A,B,C,IF should be read as if (A) then (B) else (C)
 */
class IfElse extends BooleanOperator
{
    public const NAME = 'IF';

    protected ?int $parameterCount = 3;
}
