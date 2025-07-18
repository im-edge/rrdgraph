<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Graph\Instruction;

use IMEdge\RrdGraph\Color;
use IMEdge\RrdGraph\DataType\FloatType;
use IMEdge\RrdGraph\DataType\StringType;
use IMEdge\RrdGraph\Render;

/**
 * man rrdgraph_graph
 * ------------------
 * Draw a horizontal line at value. HRULE acts much like LINE except that will
 * have no effect on the scale of the graph. If a HRULE is outside the graphing
 * area it will just not be visible and it will not appear in the legend by
 * default.
 *
 * Synopsis
 * --------
 * HRULE:value#color[:[legend][:dashes[=on_s[,off_s[,on_s,off_s]...]][:dash-offset=offset]]]
 */
class HRule implements GraphInstructionInterface
{
    use Dashes;

    public const TAG = 'HRULE';

    protected FloatType $value;
    protected ?Color $color = null;
    protected ?StringType $legend = null;

    final public function __construct(FloatType $value, ?Color $color = null, ?StringType $legend = null)
    {
        $this->value = $value;
        $this->color = $color;
        $this->legend = $legend;
    }

    public function __toString(): string
    {
        return self::TAG
            . ':'
            . $this->value
            . $this->color
            . Render::optionalParameter($this->legend)
            . $this->renderDashProperties();
    }

    public static function fromParameters(array $parameters): HRule
    {
        $first = array_shift($parameters);
        $parts = explode('#', $first ?? '');
        $value = FloatType::parse(array_shift($parts));
        if (! empty($parts)) {
            $color = new Color(array_shift($parts));
        } else {
            $color = null;
        }
        // TODO: Dashes?
        $legend = new StringType(array_shift($parameters) ?? '');

        return  new static($value, $color, $legend);
    }
}
