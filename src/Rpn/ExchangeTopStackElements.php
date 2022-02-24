<?php

namespace gipfl\RrdGraph\Rpn;

/**
 * Exchange the two top elements
 */
class ExchangeTopStackElements extends StackOperator
{
    const NAME = 'EXC';

    protected ?int $parameterCount = 2;
}
