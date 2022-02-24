<?php

namespace gipfl\RrdGraph\DataType;

use InvalidArgumentException;
use function preg_match;

class IntegerType implements DataTypeInterface
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public static function parse(string $string): IntegerType
    {
        if (preg_match('/^-?\d+$/', $string)) {
            return new static((int) $string);
        }

        throw new InvalidArgumentException("Integer expected, got '$string");
    }
}
