<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

/**
 * Sine (input in radians)
 */
class Sin extends ArithmeticOperator
{
    const NAME = 'SIN';

    protected ?int $parameterCount = 1;
}
