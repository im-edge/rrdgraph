<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Convert angle in radians to degrees
 */
class Rad2Deg extends ArithmeticOperator
{
    public const NAME = 'RAD2DEG';

    protected ?int $parameterCount = 1;
}
