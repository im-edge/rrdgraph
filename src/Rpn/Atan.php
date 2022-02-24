<?php

namespace gipfl\RrdGraph\Rpn;

/**
 * Arctangent (output in radians)
 */
class Atan extends ArithmeticOperator
{
    const NAME = 'ATAN';

    protected ?int $parameterCount = 1;
}
