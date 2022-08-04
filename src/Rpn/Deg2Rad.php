<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

/**
 * Convert angle in degrees to radians
 */
class Deg2Rad extends ArithmeticOperator
{
    const NAME = 'DEG2RAD';

    protected ?int $parameterCount = 1;
}
