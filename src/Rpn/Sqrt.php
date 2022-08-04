<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

/**
 * Square root
 */
class Sqrt extends ArithmeticOperator
{
    const NAME = 'SQRT';

    protected ?int $parameterCount = 1;
}
