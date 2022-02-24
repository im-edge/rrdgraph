<?php

namespace gipfl\RrdGraph\Rpn;

/**
 * Duplicate the top element
 */
class DuplicateTopStackElement extends StackOperator
{
    const NAME = 'DUP';

    protected ?int $parameterCount = 1;
}
