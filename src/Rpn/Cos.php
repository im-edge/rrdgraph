<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Cosine (input in radians)
 */
class Cos extends ArithmeticOperator
{
    public const NAME = 'COS';

    protected ?int $parameterCount = 1;
}
