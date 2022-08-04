<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

class PredictPerc extends SetOperator
{
    const NAME = 'PREDICTPERC';
    protected ?int $parameterCount = 3;
}
