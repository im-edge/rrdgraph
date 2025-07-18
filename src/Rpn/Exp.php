<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Exp (natural logarithm)
 */
class Exp extends ArithmeticOperator
{
    public const NAME = 'EXP';

    protected ?int $parameterCount = 1;
}
