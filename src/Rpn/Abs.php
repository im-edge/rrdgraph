<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Take the absolute value
 */
class Abs extends ArithmeticOperator
{
    public const NAME = 'ABS';

    protected ?int $parameterCount = 1;
}
