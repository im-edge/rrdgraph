<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

/**
 * Take the absolute value
 */
class Abs extends ArithmeticOperator
{
    const NAME = 'ABS';

    protected ?int $parameterCount = 1;
}
