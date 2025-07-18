<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Arctangent (output in radians)
 */
class Atan extends ArithmeticOperator
{
    public const NAME = 'ATAN';

    protected ?int $parameterCount = 1;
}
