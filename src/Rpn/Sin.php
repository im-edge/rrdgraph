<?php

namespace gipfl\RrdGraph\Rpn;

/**
 * Sine (input in radians)
 */
class Sin extends ArithmeticOperator
{
    const NAME = 'SIN';

    protected ?int $parameterCount = 1;
}
