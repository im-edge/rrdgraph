<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Graph\Instruction;

use IMEdge\RrdGraph\DataType\BooleanType;

/**
 * Normally the graphing function makes sure that the entire LINE or AREA
 * is visible in the chart. The scaling of the chart will be modified
 * accordingly if necessary. Any LINE or AREA can be excluded from this
 * process by adding the option skipscale.
 */
trait SkipScale
{
    protected ?BooleanType $skipscale = null;

    public function isSkipScale(): bool
    {
        return $this->skipscale && $this->skipscale->getValue();
    }

    public function setSkipScale(bool $skipScale = true): self
    {
        $this->skipscale = new BooleanType($skipScale, 'skipscale');
        return $this;
    }
}
