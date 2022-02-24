<?php

namespace gipfl\RrdGraph\DataType;

interface DataTypeInterface
{
    public function __toString();
    public static function parse(string $string): DataTypeInterface;
}
