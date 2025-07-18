<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Push the nth element onto the stack
 *
 *     a,b,c,d,3,INDEX -> a,b,c,d,b
 */
class Index extends StackOperator
{
    public const NAME = 'INDEX';
}
