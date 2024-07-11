<?php

namespace gipfl\RrdGraph\Graph\Instruction;

interface InstructionWithVariableInterface
{
    public function renameVariable(string $oldName, string $newName);
}
