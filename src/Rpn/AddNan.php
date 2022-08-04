<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

/**
 * NAN-safe addition. If one parameter is NAN/UNKNOWN it'll be treated as zero.
 * If both parameters are NAN/UNKNOWN, NAN/UNKNOWN will be returned.
 */
class AddNan extends ArithmeticOperator
{
    const NAME = 'ADDNAN';
}
