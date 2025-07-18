<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Sine (input in radians)
 */
class Sin extends ArithmeticOperator
{
    public const NAME = 'SIN';

    protected ?int $parameterCount = 1;
}
