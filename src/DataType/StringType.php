<?php

namespace gipfl\RrdGraph\DataType;

use function addcslashes;
use function stripcslashes;
use function strlen;

class StringType implements DataTypeInterface
{
    protected string $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function getRawString(): string
    {
        return $this->string;
    }

    public function __toString(): string
    {
        if (preg_match('/^[A-z0-9._-]+$/', $this->string)) {
            return $this->string;
        }

        return "'" . addcslashes($this->string, "':") . "'";
    }

    public static function parse(string $string): StringType
    {
        if (strlen($string) > 1) {
            $string = stripcslashes($string);
            if ($string[0] === "'" && $string[-1] === "'") {
                $string = substr($string, 1, -1);
            }
        }

        return new StringType($string);
    }
}
