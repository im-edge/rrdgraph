<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Graph\Instruction;

/**
 * Graph the following elements with a specified time offset
 *
 * man rrdgraph_graph
 * ------------------
 * Using this command RRDtool will graph the following elements with the
 * specified offset. For instance, you can specify an offset of
 * ( 7*24*60*60 = ) 604'800 seconds to "look back" one week. Make sure to tell
 * the viewer of your graph you did this ...
 *
 * As with the other graphing elements, you can specify a number or a variable
 * here.
 *
 * Synopsis
 * --------
 * SHIFT:vname:offset
 */
class Shift implements GraphInstructionInterface
{
    const TAG = 'SHIFT';

    protected string $variableName;
    protected int $offset;

    public function __construct(string $vname, int $offset)
    {
        $this->setVariableName($vname);
        $this->setOffset($offset);
    }

    public function getVariableName(): string
    {
        return $this->variableName;
    }

    public function setVariableName(string $variableName): self
    {
        $this->variableName = $variableName;
        return $this;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function setOffset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function __toString(): string
    {
        return self::TAG . ':' . $this->getVariableName() . ':' . $this->getOffset();
    }
}
