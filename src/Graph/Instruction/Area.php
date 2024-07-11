<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Graph\Instruction;

use IMEdge\RrdGraph\Color;
use IMEdge\RrdGraph\DataType\BooleanType;
use IMEdge\RrdGraph\DataType\FloatType;
use IMEdge\RrdGraph\DataType\IntegerType;
use IMEdge\RrdGraph\Render;

/**
 * Draw a filled area
 *
 * man rrdgraph_graph
 * ------------------
 * See LINE, however the area between the x-axis and the line will be filled.
 *
 * Synopsis
 * --------
 * AREA:value[#color][:[legend][:STACK][:skipscale]]
 * AREA:value[#color[#color2]][:[legend][:STACK][:skipscale][:gradheight=y]
 *
 * @method static Area fromParameters(array $parameters)()
 */
class Area extends DefinitionBasedGraphInstruction
{
    use SkipScale;
    use Stack;

    public const TAG = 'AREA';
    public const OPTIONAL_PARAMETERS = [
        'STACK'      => BooleanType::class,
        'skipscale'  => BooleanType::class,
        'gradheight' => IntegerType::class, // TODO: Float?
    ];

    protected ?Color $color2 = null;
    /**
     * The gradheight parameter can create three different behaviors. If
     * gradheight > 0, then the gradient is a fixed height, starting at the
     * line going down. If gradheight < 0, then the gradient starts at a fixed
     * height above the x-axis, going down to the x-axis. If height == 0, then
     * the gradient goes from the line to x-axis.
     *
     * The default value for gradheight is 50.
     */
    protected ?FloatType $gradheight = null;

    public function __toString(): string
    {
        return self::TAG . ':'
            . $this->definition
            . $this->color
            . $this->color2
            . Render::optionalParameter($this->legend, [$this->STACK, $this->skipscale])
            . Render::optionalParameter($this->STACK) // Named
            . Render::optionalParameter($this->skipscale)
            . Render::optionalNamedParameter('gradheight', $this->gradheight)
        ;
    }

    public function getColor2(): ?Color
    {
        return $this->color2;
    }

    public function setColor2(?Color $color2): void
    {
        $this->color2 = $color2;
    }

    public function getGradheight(): ?FloatType
    {
        return $this->gradheight;
    }

    public function setGradheight(?FloatType $gradheight): void
    {
        $this->gradheight = $gradheight;
    }
}
