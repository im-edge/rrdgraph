<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Square root
 */
class Sqrt extends ArithmeticOperator
{
    public const NAME = 'SQRT';

    protected ?int $parameterCount = 1;
}
