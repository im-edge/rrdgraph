<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Graph\Instruction;

use IMEdge\RrdGraph\InstructionInterface;

interface GraphInstructionInterface extends InstructionInterface
{
    public static function fromParameters(array $parameters): self;
}
