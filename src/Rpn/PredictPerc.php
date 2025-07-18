<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

class PredictPerc extends SetOperator
{
    public const NAME = 'PREDICTPERC';
    protected ?int $parameterCount = 3;
}
