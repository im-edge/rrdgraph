<?php declare(strict_types=1);

namespace gipfl\RrdGraph;

interface InstructionInterface
{
    public static function fromParameters(array $parameters): InstructionInterface;
    public function __toString(): string;
}
