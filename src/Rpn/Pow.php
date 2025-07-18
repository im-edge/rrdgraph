<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * value,power,POW
 *
 * Raise value to the power of power.
 */
class Pow extends ArithmeticOperator
{
    public const NAME = 'POW';

    protected ?int $parameterCount = 2;
}
