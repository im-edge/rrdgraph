<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Log (natural logarithm)
 */
class Log extends ArithmeticOperator
{
    public const NAME = 'LOG';

    protected ?int $parameterCount = 1;
}
