<?php

namespace gipfl\RrdGraph\DataType;

use function strlen;

class BooleanType implements DataTypeInterface
{
    protected bool $value;
    protected string $label;

    public function __construct(bool $value, string $label)
    {
        $this->value = $value;
        $this->label = $label;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isTrue(): bool
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value ? $this->label : '';
    }

    public static function parse(string $string): BooleanType
    {
        if (strlen($string) > 0) {
            return new static(true, $string);
        }

        throw new \RuntimeException('Cannot determine boolean type öabel from empty string');
    }
}
