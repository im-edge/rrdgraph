<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

class Predict extends SetOperator
{
    const NAME = 'PREDICT';
    protected ?int $parameterCount = 2;
}
