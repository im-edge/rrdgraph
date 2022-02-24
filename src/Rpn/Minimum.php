<?php

namespace gipfl\RrdGraph\Rpn;

/**
 * Return the corresponding value, MINIMUM also returns the first occurrence of
 * that value in the time component
 *
 * Example: VDEF:min=mydata,MINIMUM
 */
class Minimum extends VariablesOperator
{
    const NAME = 'MINIMUM';
}
