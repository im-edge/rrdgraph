<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

abstract class SetOperator extends Operator
{
    protected bool $isVariadic = true;
}
