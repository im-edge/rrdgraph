<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Rpn;

abstract class SpecialValue extends Operator
{
    protected ?int $parameterCount = 0;
}
