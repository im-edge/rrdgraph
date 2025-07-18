<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Exchange the two top elements
 */
class ExchangeTopStackElements extends StackOperator
{
    public const NAME = 'EXC';

    protected ?int $parameterCount = 2;
}
