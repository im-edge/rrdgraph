<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Will return 1.0 whenever a step is the first of the given period (week). The
 * periods are determined according to the local timezone AND the LC_TIME
 * settings.
 *
 * CDEF:wtotal=rate,STEPWIDTH,*,NEWDAY,0,PREV,IF,ADDNAN
 */
class NewWeek extends TimeValue
{
    public const NAME = 'NEWWEEK';
}
