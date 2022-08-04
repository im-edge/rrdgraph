<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

/**
 * Round down to the nearest integer
 */
class Floor extends ArithmeticOperator
{
    const NAME = 'FLOOR';

    protected ?int $parameterCount = 1;
}
