<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Graph\Instruction;

use gipfl\RrdGraph\DataType\BooleanType;

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
        return $this->s && $this->skipScale->getValue();
    }
}
