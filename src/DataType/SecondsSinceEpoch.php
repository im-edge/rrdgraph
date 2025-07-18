<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\DataType;

class SecondsSinceEpoch extends TimeType
{
    protected int $seconds;

    public function __construct(int $seconds)
    {
        $this->seconds = $seconds;
    }

    public function __toString(): string
    {
        return (string) $this->seconds;
    }
}
