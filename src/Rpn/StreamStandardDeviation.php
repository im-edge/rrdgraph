<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Returns the standard deviation of the values
 *
 * Example: VDEF:stdev=mydata,STDEV
 */
class StreamStandardDeviation extends VariablesOperator
{
    // TODO: teach the parser how to distinct this from 'normal' STDEV
    public const NAME = 'STDEV';
}
