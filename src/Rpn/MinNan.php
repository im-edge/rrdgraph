<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * NAN-safe version of MIN.
 *
 * If one of the input numbers is unknown then the result of the operation will
 * be the other one. If both are unknown, then the result of the operation is
 * unknown.
 */
class MinNan extends CompareValuesOperator
{
    public const NAME = 'MINNAN';
}
