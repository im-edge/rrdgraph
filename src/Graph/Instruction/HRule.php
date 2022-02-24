<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Graph\Instruction;

use gipfl\RrdGraph\Render;

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
class HRule extends DefinitionBasedGraphInstruction
{
    use Dashes;

    const TAG = 'HRULE';

    public function __toString(): string
    {
        return self::TAG
            . ':'
            . $this->definition
            . $this->color
            . Render::optionalParameter($this->legend)
            . $this->renderDashProperties();
    }
}
