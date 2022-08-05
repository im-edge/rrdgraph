<?php

namespace gipfl\Tests\RrdGraph\Data;

use gipfl\RrdGraph\Data\Assignment;
use PHPUnit\Framework\TestCase;

class DefTest extends TestCase
{
    public function testParsesAndRendersDefString()
    {
        $in = "DEF:'def_average_iowait'='2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd':'iowait':AVERAGE";
        $out = "DEF:def_average_iowait=2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd:iowait:AVERAGE";
        $this->assertEquals($out, (string) Assignment::parse($in));

        $in = "DEF:'defa'='2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd':'iowait':AVERAGE";
        $out = "DEF:defa=2d/07/2d07f300dbec4dc5a30caa61ae76ca0a.rrd:iowait:AVERAGE";
        $this->assertEquals($out, (string) Assignment::parse($in));
    }
}
