<?php declare(strict_types=1);

namespace gipfl\RrdGraph;

use gipfl\RrdGraph\DataType\BooleanType;
use gipfl\RrdGraph\DataType\DataTypeInterface;
use InvalidArgumentException;
use function addcslashes;
use function ctype_digit;
use function is_int;
use function preg_replace;
use function sprintf;
use function strlen;

final class Render
{
    public static function string(?string $string): ?string
    {
        if ($string === null || strlen($string) === 0) {
            return null;
        }

        // if alnum -> just return it as is?

        // TODO: Check and fix
        return "'" . addcslashes($string, "':") . "'";
    }

    public static function optionalParameter(?DataTypeInterface $parameter, $followingFlags = []): string
    {
        if ($parameter === null) {
            return self::emptyDependingOnFollowingFlags($followingFlags);
        }
        $string = (string) $parameter;
        if (strlen($string) > 0) {
            return ":$parameter";
        }


        return self::emptyDependingOnFollowingFlags($followingFlags);
    }

    public static function optionalNamedParameter(string $parameter, $value): string
    {
        if ($value !== null && strlen($value)) {
            return ":${parameter}=${value}";
        } else {
            return '';
        }
    }

    public static function namedParameter(string $parameter, DataTypeInterface $value): string
    {
        return ":$parameter=$value";
    }

    public static function optionalNamedBoolean(string $parameter, ?bool $value): string
    {
        if ($value) {
            return ":${parameter}";
        } else {
            return '';
        }
    }

    public static function float($number): string
    {
        if (is_float($number)) {
            return preg_replace('/\.0+$/', '', preg_replace('/(\..+?)0+$/', '\1', sprintf('%.6F', $number)));
        } elseif (is_int($number)) {
            return (string) $number;
        } elseif (ctype_digit($number)) {
            return (string) (int) $number;
        }

        throw new InvalidArgumentException("Number expected, got $number");
    }

    protected static function emptyDependingOnFollowingFlags($followingFlags = []): string
    {
        /** @var ?BooleanType $boolean */
        foreach ($followingFlags as $boolean) {
            if ($boolean !== null && $boolean->isTrue()) {
                return ':';
            }
        }

        return '';
    }
}
