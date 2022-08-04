<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

abstract class SetOperator extends Operator
{
    protected bool $isVariadic = true;
}
