<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Graph\Instruction;

use gipfl\RrdGraph\InstructionInterface;

interface GraphInstructionInterface extends InstructionInterface
{
    public static function fromParameters(array $parameters): self;
}
