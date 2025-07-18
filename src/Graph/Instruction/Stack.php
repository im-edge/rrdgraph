<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Graph\Instruction;

use IMEdge\RrdGraph\DataType\BooleanType;

/**
 * If the optional STACK modifier is used, this line/area is stacked on top of
 * the previous element which can be a LINE or an AREA.
 */
trait Stack
{
    protected ?BooleanType $STACK = null;

    public function setStack(bool $stack = true): self
    {
        $this->STACK = new BooleanType($stack, 'STACK');
        return $this;
    }

    public function isStack(): bool
    {
        return $this->STACK && $this->STACK->isTrue();
    }
}
