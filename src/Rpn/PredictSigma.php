<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

class PredictSigma extends SetOperator
{
    const NAME = 'PREDICTSIGMA';
    protected ?int $parameterCount = 2;
}
