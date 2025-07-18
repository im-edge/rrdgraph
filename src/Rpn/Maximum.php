<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Return the corresponding value, MAXIMUM also returns the first occurrence of
 * that value in the time component
 *
 * Example: VDEF:max=mydata,MAXIMUM
 */
class Maximum extends VariablesOperator
{
    public const NAME = 'MAXIMUM';
}
