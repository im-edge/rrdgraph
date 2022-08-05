<?php declare(strict_types=1);

namespace gipfl\RrdGraph\DataType;

class AtStyleTime extends TimeType
{
    protected string $time;

    // TODO: https://oss.oetiker.ch/rrdtool/doc/rrdfetch.en.html#AT-STYLE_TIME_SPECIFICATION
    public function __construct(string $time)
    {
        $this->time = $time;
    }

    public static function parse(string $string): AtStyleTime
    {
        return new AtStyleTime(stripcslashes($string));
    }

    public function __toString()
    {
        return addcslashes($this->time, "':");
    }
}
