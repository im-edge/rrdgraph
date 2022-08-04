<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

/**
 * value,power,POW
 *
 * Raise value to the power of power.
 */
class Pow extends ArithmeticOperator
{
    const NAME = 'POW';

    protected ?int $parameterCount = 2;
}
