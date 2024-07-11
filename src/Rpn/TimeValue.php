<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Time inside RRDtool is measured in seconds since the epoch. The epoch is
 * defined to be Thu Jan 1 00:00:00 UTC 1970.
 */
abstract class TimeValue extends Operator
{
    protected ?int $parameterCount = 0;
}
