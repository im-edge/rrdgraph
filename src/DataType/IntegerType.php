<?php

namespace gipfl\RrdGraph\DataType;

use InvalidArgumentException;
use function preg_match;

class IntegerType implements DataTypeInterface
{
    const REGEXP = '/^-?\d+$/';
    protected int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public static function isValid(string $string): bool
    {
        return preg_match(self::REGEXP, $string);
    }

    public static function parse(string $string): IntegerType
    {
        if (static::isValid($string)) {
            return new static((int) $string);
        }

        throw new InvalidArgumentException("Integer expected, got '$string");
    }
}
