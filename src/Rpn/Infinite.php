<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Pushes a positive infinite value on the stack. When such a value is graphed,
 * it appears at the top or bottom of the graph, no matter what the actual
 * value on the y-axis is.
 */
class Infinite extends SpecialValue
{
    public const NAME = 'INF';
}
