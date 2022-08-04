<?php declare(strict_types=1);

namespace gipfl\RrdGraph\DataType;

abstract class TimeType implements TimeInterface
{
    public static function parse(string $string): TimeType
    {
        if (ctype_digit($string)) {
            return new SecondsSinceEpoch((int) $string);
        }

        return new AtStyleTime($string);
    }
}
