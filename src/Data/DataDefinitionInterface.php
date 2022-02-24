<?php declare(strict_types=1);

namespace gipfl\RrdGraph\Data;

use gipfl\RrdGraph\InstructionInterface;

interface DataDefinitionInterface extends InstructionInterface
{
    public static function fromParameters(array $parameters): DataDefinitionInterface;
}
