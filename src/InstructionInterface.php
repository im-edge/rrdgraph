<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph;

interface InstructionInterface
{
    /**
     * @param string[] $parameters
     * @return static|self -> we do not (yet) require PHP8
     */
    public static function fromParameters(array $parameters): self;
    public function __toString(): string;
}
