<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

/**
 * Duplicate the top element
 */
class DuplicateTopStackElement extends StackOperator
{
    public const NAME = 'DUP';

    protected ?int $parameterCount = 1;
}
