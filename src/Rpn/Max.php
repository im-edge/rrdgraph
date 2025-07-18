<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Pops two elements from the stack and returns the larger
 *
 * Note that infinite is larger than anything else. If one of the input numbers
 * is unknown then the result of the operation will be unknown too.
 */
class Max extends CompareValuesOperator
{
    public const NAME = 'MAX';
}
