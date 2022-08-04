<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

/**
 * Round up to the nearest integer
 */
class Ceil extends ArithmeticOperator
{
    const NAME = 'CEIL';

    protected ?int $parameterCount = 1;
}
