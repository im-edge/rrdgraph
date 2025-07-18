<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Graph\Instruction;

use IMEdge\RrdGraph\DataType\FloatType;
use IMEdge\RrdGraph\DataType\StringType;
use IMEdge\RrdGraph\Render;

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
 *
 * @method static Tick fromParameters(array $parameters)()
 */
class Tick extends DefinitionBasedGraphInstruction
{
    use Dashes;

    public const TAG = 'TICK';
    public const OPTIONAL_PARAMETERS = [ // Hint: fraction still does not work, legend should not be required
        'fraction' => FloatType::class,
        'legend'   => StringType::class,
    ];

    protected ?FloatType $fraction = null;

    public function getFraction(): ?FloatType
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
    public function setFraction(FloatType $fraction): self
    {
        $this->fraction = $fraction;
        return $this;
    }

    public function __toString(): string
    {
        return self::TAG . ':'
            . $this->definition
            . $this->color
            . Render::optionalParameter($this->fraction)
            . Render::optionalParameter($this->legend);
    }
}
