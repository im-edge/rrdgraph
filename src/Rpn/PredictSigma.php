<?php

namespace gipfl\RrdGraph\Rpn;

class PredictSigma extends SetOperator
{
    const NAME = 'PREDICTSIGMA';
    protected ?int $parameterCount = 2;
}
