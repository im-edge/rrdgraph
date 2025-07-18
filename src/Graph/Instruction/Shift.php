<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\Graph\Instruction;

use IMEdge\RrdGraph\Data\VariableName;
use IMEdge\RrdGraph\DataType\IntegerType;

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
    public const TAG = 'SHIFT';

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

    public function renameVariable(string $oldName, string $newName): void
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
        if (! is_string($parameters[1])) {
            throw new \RuntimeException('SHIFT requires a numeric string as second parameter');
        }
        return new Shift(
            new VariableName($parameters[0]),
            new IntegerType((int) $parameters[1])
        );
    }
}
