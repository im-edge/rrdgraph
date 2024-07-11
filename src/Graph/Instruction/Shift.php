<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Graph\Instruction;

use gipfl\RrdGraph\Data\VariableName;
use gipfl\RrdGraph\DataType\IntegerType;

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
class Shift implements GraphInstructionInterface, InstructionWithVariableInterface
{
    const TAG = 'SHIFT';

    protected VariableName $variableName;
    protected IntegerType $offset;

    public function __construct(VariableName $variableName, IntegerType $offset)
    {
        $this->variableName = $variableName;
        $this->offset = $offset;
    }

    public function getVariableName(): VariableName
    {
        return $this->variableName;
    }

    public function renameVariable(string $oldName, string $newName)
    {
        if ($this->variableName->getName() === $oldName) {
            $this->variableName->setName($newName);
        }
    }

    public function getOffset(): IntegerType
    {
        return $this->offset;
    }

    public function __toString(): string
    {
        return self::TAG . ':' . $this->getVariableName() . ':' . $this->getOffset();
    }

    public static function fromParameters(array $parameters): Shift
    {
        $parameters[0] = new VariableName($parameters[0]);
        $parameters[1] = new IntegerType((int) $parameters[1]);
        return new Shift(...$parameters);
    }
}
