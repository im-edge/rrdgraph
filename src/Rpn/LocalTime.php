<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

/**
 * Takes the time as defined by TIME, applies the time zone offset valid at
 * that time including daylight saving time if your OS supports it, and pushes
 * the result on the stack.
 */
class LocalTime extends TimeValue
{
    const NAME = 'LTIME';
}
