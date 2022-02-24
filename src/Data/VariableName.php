<?php

namespace gipfl\RrdGraph\Data;

class VariableName
{
    protected string $value;

    public function __construct(string $name)
    {
        $this->value = $name;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
