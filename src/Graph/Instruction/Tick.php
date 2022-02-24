<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Graph\Instruction;

use gipfl\RrdGraph\Render;

/**
 * Plot tick marks
 *
 * man rrdgraph_graph
 * ------------------
 * Plot a tick mark (a vertical line) for each value of vname that is non-zero
 * and not *UNKNOWN*.
 *
 * Note that the color specification is not optional
 *
 * Synopsis
 * --------
 * TICK:vname#rrggbb[aa][:fraction[:legend]]
 */
class Tick extends DefinitionBasedGraphInstruction
{
    use Dashes;

    const TAG = 'TICK';

    protected ?float $fraction = null;
    protected bool $skipScale = false;

    public function getFraction(): ?float
    {
        return $this->fraction;
    }

    /**
     * The fraction argument specifies the length of the tick mark as a fraction
     * of the y-axis; the default value is 0.1 (10% of the axis)
     *
     * The TICK marks normally start at the lower edge of the graphing area. If
     * the fraction is negative they start at the upper border of the graphing
     * area.
     */
    public function setFraction(?float $fraction): self
    {
        $this->fraction = $fraction;
        return $this;
    }

    protected function renderFraction(): string
    {
        return $this->fraction === null ? '' : Render::float($this->fraction);
    }

    public function __toString(): string
    {
        return self::TAG . ':'
            . $this->definition
            . $this->color
            . Render::optionalParameter($this->renderFraction())
            . Render::optionalParameter($this->legend);
    }
}
