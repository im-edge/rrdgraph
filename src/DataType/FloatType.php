<?php

namespace gipfl\RrdGraph\DataType;

use InvalidArgumentException;

class FloatType implements DataTypeInterface
{
    protected float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public static function isValid(string $string): bool
    {
        return is_numeric($string);
    }

    public static function parse(string $string): FloatType
    {
        if (static::isValid($string)) {
            return new FloatType((float) $string);
        }

        throw new InvalidArgumentException("Float expected, got '$string");
    }
}
