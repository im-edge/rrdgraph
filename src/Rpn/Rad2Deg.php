<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

/**
 * Convert angle in radians to degrees
 */
class Rad2Deg extends ArithmeticOperator
{
    const NAME = 'RAD2DEG';

    protected ?int $parameterCount = 1;
}
