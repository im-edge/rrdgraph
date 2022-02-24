<?php

namespace gipfl\RrdGraph\Rpn;

/**
 * Round up to the nearest integer
 */
class Ceil extends ArithmeticOperator
{
    const NAME = 'CEIL';

    protected ?int $parameterCount = 1;
}
