<?php

declare(strict_types=1);

namespace IMEdge\RrdGraph\DataType;

interface DataTypeInterface
{
    public function __toString();
    public static function parse(string $string): DataTypeInterface;
}
