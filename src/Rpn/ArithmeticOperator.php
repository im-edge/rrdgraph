<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

abstract class ArithmeticOperator extends Operator
{
    protected ?int $parameterCount = 2;
}
