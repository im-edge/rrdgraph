<?php

namespace IMEdge\RrdGraph\Graph\Instruction;

interface InstructionWithVariableInterface
{
    public function renameVariable(string $oldName, string $newName): void;
}
