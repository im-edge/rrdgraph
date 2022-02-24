<?php

namespace gipfl\RrdGraph\Rpn;

/**
 * Return the corresponding value, AVERAGE also returns the first occurrence of
 * that value in the time component
 *
 * Example: VDEF:avg=mydata,AVERAGE
 */
class StreamAverage extends VariablesOperator
{
    // TODO: teach the parser how to distinct this from 'normal' AVERAGE
    const NAME = 'AVERAGE';
}
