<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

abstract class SpecialValue extends Operator
{
    protected ?int $parameterCount = 0;
}
