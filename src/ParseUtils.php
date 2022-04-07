<?php

namespace gipfl\RrdGraph;

use InvalidArgumentException;
use function strlen;
use function strpos;
use function substr;

class ParseUtils
{
    public static function stripRequiredTag(string $string, string $tag): string
    {
        return static::stripRequiredPrefix($string, "$tag:");
    }

    public static function stripRequiredPrefix(string $string, string $prefix): string
    {
        $length = strlen($prefix);
        if (substr($string, 0, $length) === $prefix) {
            return substr($string, $length);
        }

        throw new InvalidArgumentException("'$prefix...' expected, got '$string'");
    }

    public static function splitKeyValue(string $string, string $separator): array
    {
        $pos = strpos($string, $separator);
        if ($pos === false) {
            throw new InvalidArgumentException(sprintf("Found no '%s' in %s", $separator, $string));
        }

        return [substr($string, 0, $pos), substr($string, $pos + 1)];
    }
}
