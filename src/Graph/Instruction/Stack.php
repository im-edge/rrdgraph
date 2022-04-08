<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Graph\Instruction;

use gipfl\RrdGraph\DataType\BooleanType;

/**
 * If the optional STACK modifier is used, this line/area is stacked on top of
 * the previous element which can be a LINE or an AREA.
 */
trait Stack
{
    protected ?BooleanType $STACK = null;

    public function isStack(): bool
    {
        return $this->STACK && $this->STACK->isTrue();
    }
}
