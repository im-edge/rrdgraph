<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Return the last non-nan or infinite value for the selected data stream,
 * including its timestamp.
 *
 * Example: VDEF:last=mydata,LAST
 */
class Last extends VariablesOperator
{
    const NAME = 'LAST';
}
