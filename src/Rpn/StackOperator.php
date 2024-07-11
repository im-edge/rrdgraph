<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Processing the stack directly
 *
 * TODO: figure out how to deal with this at parse time
 */
abstract class StackOperator extends Operator
{
    protected bool $isVariadic = true;
}
