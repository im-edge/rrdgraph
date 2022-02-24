<?php

namespace gipfl\RrdGraph;

use InvalidArgumentException;

trait ClassRegistry
{
    public static function getClass(string $tag): string
    {
        if (isset(static::IMPLEMENTATIONS[$tag])) {
            return static::IMPLEMENTATIONS[$tag];
        }

        throw new InvalidArgumentException("'$tag' is not a known TAG");
    }

    public static function isKnown(string $name): bool
    {
        return isset(self::IMPLEMENTATIONS[$name]);
    }
}
