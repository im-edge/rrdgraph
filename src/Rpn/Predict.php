<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

class Predict extends SetOperator
{
    const NAME = 'PREDICT';
    protected ?int $parameterCount = 2;
}
