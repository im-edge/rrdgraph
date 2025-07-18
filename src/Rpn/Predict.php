<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

class Predict extends SetOperator
{
    public const NAME = 'PREDICT';
    protected ?int $parameterCount = 2;
}
