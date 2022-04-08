<?php declare(strict_types=1);

namespace gipfl\RrdGraph;

interface InstructionInterface
{
    /**
     * @param array $parameters
     * @return static
     */
    #[\ReturnTypeWillChange]
    public static function fromParameters(array $parameters);
    public function __toString(): string;
}
