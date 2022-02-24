<?php

namespace gipfl\RrdGraph\Rpn;

/**
 * Take the absolute value
 */
class Abs extends ArithmeticOperator
{
    const NAME = 'ABS';

    protected ?int $parameterCount = 1;
}
