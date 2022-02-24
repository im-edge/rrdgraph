<?php

namespace gipfl\RrdGraph\Rpn;

/**
 * Log (natural logarithm)
 */
class Log extends ArithmeticOperator
{
    const NAME = 'LOG';

    protected ?int $parameterCount = 1;
}
